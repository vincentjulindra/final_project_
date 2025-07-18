<?php
use App\Http\Controllers\EncryptionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/encrypt', [EncryptionController::class, 'encryptData']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // GET /tasks hanya untuk admin
    Route::get('/tasks', [TaskController::class, 'index'])->middleware('role:admin');

    // POST /tasks untuk semua user yang sudah login
    Route::post('/tasks', [TaskController::class, 'store']);

    // DELETE /tasks/{task} hanya untuk pemilik task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->middleware('task.owner');
});