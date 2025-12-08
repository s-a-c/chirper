<?php

declare(strict_types=1);

use App\Http\Controllers\ChirpController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

/** @return View */
Route::get('/', fn (): Illuminate\View\View|View => view('welcome'));

Route::get('/chirper', [ChirpController::class, 'index'])
    ->name('chirps.index');
