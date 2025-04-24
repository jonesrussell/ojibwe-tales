<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return inertia('VideoRecorder');
});

Route::post('/api/videos', [VideoController::class, 'store']);
