<?php

declare(strict_types=1);

// Compliant with [.ai/AI-GUIDELINES.md](../../.ai/AI-GUIDELINES.md) v374a22e55a53ea38928957463e1f0ef28f820080a27e0466f35d46c20626fa72

use App\Http\Controllers\ChirpController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

/** @return View */
Route::get('/', fn (): Illuminate\View\View|View => view('welcome'));

Route::get('/chirper', [ChirpController::class, 'index'])->name('chirps.index');
