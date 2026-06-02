<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API V1
use App\Http\Controllers\Api\V1\{
    Ollama\OllamaController
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API (OK)
Route::get('/', function () {
    return response()->json([
        'success'   => true,
    ], 200);
});

// Ollama
Route::post('ollama/generate', [OllamaController::class, 'generate']); // Generate
