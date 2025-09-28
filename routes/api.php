<?php

use App\Http\Controllers\ChecklistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/history', [ChecklistController::class, 'history']);
Route::get('/trends', [ChecklistController::class, 'trends']);
Route::get('/frequent-failures', [ChecklistController::class, 'frequentFailures']);
Route::get('/category-analysis', [ChecklistController::class, 'categoryAnalysis']);
