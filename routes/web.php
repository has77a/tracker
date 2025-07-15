<?php

use App\Http\Controllers\Web\VisitsController;
use Illuminate\Support\Facades\Route;

Route::get('/visits', [VisitsController::class, 'index'])->name('visits.index');

Route::get('/', function () {
    return view('welcome');
});
