<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SqlAgentController;

Route::post('/ai/text-to-sql', [SqlAgentController::class, 'generate']);
Route::get('/ai/history', [SqlAgentController::class, 'history']);