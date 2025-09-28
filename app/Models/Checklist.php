<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_label',
        'user_id',
        'total_questions',
        'yes_count',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'yes_count' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    /**
     * Calculate overall score percentage
     */
    public function getScoreAttribute()
    {
        if ($this->total_questions == 0) {
            return 0;
        }
        
        return round(($this->yes_count / $this->total_questions) * 100);
    }

    /**
     * Get score color class for UI
     */
    public function getScoreColorAttribute()
    {
        $score = $this->score;
        
        if ($score >= 80) {
            return 'success';
        } elseif ($score >= 50) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    /**
     * Get category scores
     */
    public function getCategoryScores()
    {
        $categories = [];
        
        foreach ($this->items->groupBy('category') as $category => $items) {
            $total = $items->count();
            $yesCount = $items->where('answer', true)->count();
            $score = $total > 0 ? round(($yesCount / $total) * 100) : 0;
            
            $categories[$category] = [
                'total' => $total,
                'yes_count' => $yesCount,
                'score' => $score,
                'color' => $score >= 80 ? 'success' : ($score >= 50 ? 'warning' : 'danger')
            ];
        }
        
        return $categories;
    }

    /**
     * Generate week label using ISO week format
     */
    public static function generateWeekLabel()
    {
        return Carbon::now()->format('o-\WW');
    }
}
