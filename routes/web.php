<?php

use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChecklistController::class, 'index'])->name('checklist.index');
Route::post('/submit', [ChecklistController::class, 'store'])->name('checklist.store');
Route::get('/history', [ChecklistController::class, 'history'])->name('checklist.history');
