<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FoxProController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "api" middleware group. Make something great!
|
*/

// Ruta para realizar una consulta SELECT simple
Route::get('select', [FoxProController::class, 'select']);
Route::get('historia-urgencias', [FoxProController::class, 'historiaUrgencias']);
Route::post('/insert', [FoxProController::class, 'insert']);
Route::patch('/update', [FoxProController::class, 'update']);
Route::delete('/delete', [FoxProController::class, 'delete']);
Route::get('/sync-all-records', [FoxProController::class, 'syncAllRecords']);



