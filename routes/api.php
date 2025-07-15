<?php

use App\Http\Controllers\Api\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/collect', [TrackerController::class, 'collect']);
