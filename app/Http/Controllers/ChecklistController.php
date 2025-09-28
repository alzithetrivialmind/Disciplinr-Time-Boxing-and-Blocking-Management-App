<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    /**
     * Display the checklist form and history
     */
    public function index()
    {
        $questions = config('checklist');
        $checklists = Checklist::with('items')
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        return view('checklist.index', compact('questions', 'checklists'));
    }

    /**
     * Store a new checklist
     */
    public function store(Request $request)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $request->input('answers');
        $questions = config('checklist');
        
        // Calculate totals
        $totalQuestions = 0;
        $yesCount = 0;
        
        foreach ($questions as $category => $categoryQuestions) {
            $totalQuestions += count($categoryQuestions);
        }

        // Create checklist
        $checklist = Checklist::create([
            'week_label' => Checklist::generateWeekLabel(),
            'total_questions' => $totalQuestions,
            'yes_count' => 0, // Will be calculated below
        ]);

        // Create checklist items and count yes answers
        foreach ($questions as $category => $categoryQuestions) {
            foreach ($categoryQuestions as $index => $question) {
                $answer = isset($answers[$category][$index]) && $answers[$category][$index] === '1';
                
                ChecklistItem::create([
                    'checklist_id' => $checklist->id,
                    'category' => $category,
                    'question' => $question,
                    'answer' => $answer,
                ]);

                if ($answer) {
                    $yesCount++;
                }
            }
        }

        // Update checklist with actual yes count
        $checklist->update(['yes_count' => $yesCount]);

        return redirect()->route('checklist.index')
            ->with('success', 'Checklist saved successfully!');
    }

    /**
     * Get history data for API
     */
    public function history()
    {
        $checklists = Checklist::with('items')
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        $data = $checklists->map(function ($checklist) {
            return [
                'id' => $checklist->id,
                'week_label' => $checklist->week_label,
                'score' => $checklist->score,
                'score_color' => $checklist->score_color,
                'total_questions' => $checklist->total_questions,
                'yes_count' => $checklist->yes_count,
                'created_at' => $checklist->created_at->format('Y-m-d H:i:s'),
                'category_scores' => $checklist->getCategoryScores(),
            ];
        });

        return response()->json($data);
    }

    /**
     * Get trends data for charts
     */
    public function trends(Request $request)
    {
        $weeks = $request->get('weeks', 12);
        
        $trends = Checklist::select('week_label', 'yes_count', 'total_questions', 'created_at')
            ->orderBy('created_at')
            ->limit($weeks)
            ->get()
            ->map(function ($checklist) {
                return [
                    'week' => $checklist->week_label,
                    'score' => $checklist->total_questions > 0 
                        ? round(($checklist->yes_count / $checklist->total_questions) * 100) 
                        : 0,
                    'date' => $checklist->created_at->format('Y-m-d'),
                ];
            });

        return response()->json($trends);
    }

    /**
     * Get frequent failure report
     */
    public function frequentFailures()
    {
        $failures = ChecklistItem::select('question', 'category', DB::raw('COUNT(*) as fail_count'))
            ->where('answer', false)
            ->groupBy('question', 'category')
            ->orderByDesc('fail_count')
            ->limit(5)
            ->get();

        return response()->json($failures);
    }

    /**
     * Get category analysis
     */
    public function categoryAnalysis()
    {
        $analysis = ChecklistItem::select('category', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN answer = 1 THEN 1 ELSE 0 END) as yes_count'))
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                $score = $item->total > 0 ? round(($item->yes_count / $item->total) * 100) : 0;
                return [
                    'category' => $item->category,
                    'total' => $item->total,
                    'yes_count' => $item->yes_count,
                    'score' => $score,
                    'color' => $score >= 80 ? 'success' : ($score >= 50 ? 'warning' : 'danger'),
                ];
            });

        return response()->json($analysis);
    }
}
