@extends('layouts.app')

@section('title', 'Time Boxing Checklist')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h2 class="card-title h4 mb-0">
                    <i class="bi bi-list-check me-2 text-primary"></i>
                    Weekly Time Boxing Checklist
                </h2>
                <p class="text-muted mt-2 mb-0">Weekly evaluation to improve productivity and focus</p>
            </div>
            <div class="card-body">
                <form action="{{ route('checklist.store') }}" method="POST">
                    @csrf
                    
                    @foreach($questions as $category => $categoryQuestions)
                        <div class="mb-5">
                            <h5 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-{{ $category === 'Time Blocking' ? 'calendar-check' : ($category === 'Time Boxing' ? 'hourglass-split' : 'people') }} me-2"></i>
                                {{ $category }}
                            </h5>
                            
                            <div class="row">
                                @foreach($categoryQuestions as $index => $question)
                                    <div class="col-12 mb-3">
                                        <div class="form-check p-3 border rounded-3 bg-light">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="answers[{{ $category }}][{{ $index }}]" 
                                                   value="1" 
                                                   id="question_{{ $category }}_{{ $index }}">
                                            <label class="form-check-label fw-medium" for="question_{{ $category }}_{{ $index }}">
                                                {{ $question }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>
                            Save Checklist
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up me-2 text-primary"></i>
                    History & Analytics
                </h5>
            </div>
            <div class="card-body">
                @if($checklists->count() > 0)
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Recent Performance</h6>
                        @foreach($checklists->take(3) as $checklist)
                            <div class="mb-3 p-3 border rounded-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-medium">{{ $checklist->week_label }}</span>
                                    <span class="badge bg-{{ $checklist->score_color }}">
                                        {{ $checklist->score }}%
                                    </span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $checklist->score_color }}" 
                                         style="width: {{ $checklist->score }}%"></div>
                                </div>
                                <small class="text-muted">
                                    {{ $checklist->yes_count }}/{{ $checklist->total_questions }} questions
                                </small>
                                
                                <!-- Category breakdown -->
                                <div class="mt-2">
                                    @foreach($checklist->getCategoryScores() as $category => $data)
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">{{ $category }}</small>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 4px;">
                                                    <div class="progress-bar bg-{{ $data['color'] }}" 
                                                         style="width: {{ $data['score'] }}%"></div>
                                                </div>
                                                <small class="fw-medium">{{ $data['score'] }}%</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($checklists->count() > 3)
                        <div class="text-center">
                            <button class="btn btn-outline-primary btn-sm" onclick="loadMoreHistory()">
                                <i class="bi bi-arrow-down me-1"></i>
                                Load More
                            </button>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-graph-up text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">No checklist data yet</p>
                        <small class="text-muted">Complete your first checklist to see analytics</small>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Stats -->
        @if($checklists->count() > 0)
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-white border-0">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i>
                        Quick Stats
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $avgScore = $checklists->avg('score');
                        $bestWeek = $checklists->sortByDesc('score')->first();
                        $improvement = $checklists->count() > 1 ? 
                            $checklists->first()->score - $checklists->last()->score : 0;
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-2">
                                <div class="h5 mb-1 text-primary">{{ round($avgScore) }}%</div>
                                <small class="text-muted">Avg Score</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2">
                                <div class="h5 mb-1 text-success">{{ $bestWeek->score }}%</div>
                                <small class="text-muted">Best Week</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2">
                                <div class="h5 mb-1 {{ $improvement >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $improvement >= 0 ? '+' : '' }}{{ $improvement }}%
                                </div>
                                <small class="text-muted">Improvement</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Chart Modal -->
<div class="modal fade" id="chartModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Performance Trends</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="trendChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function loadMoreHistory() {
    // Implementation for loading more history
    console.log('Loading more history...');
}

// Load trends data and create chart
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/trends')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                createTrendChart(data);
            }
        })
        .catch(error => console.error('Error loading trends:', error));
});

function createTrendChart(data) {
    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(item => item.week),
            datasets: [{
                label: 'Score %',
                data: data.map(item => item.score),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
@endsection
