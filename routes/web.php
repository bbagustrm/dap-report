<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DapController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TugasController;


Route::get('table', [DapController::class, 'dataTable']);
Route::get('/daily/create', [DapController::class, 'create'])->name('dailies.create');
Route::post('/daily/store', [DapController::class, 'store'])->name('dailies.store');
Route::get('/daily/{id}', [DapController::class, 'show'])->name('dailies.show');
Route::get('/daily/edit/{id}', [DapController::class, 'edit']) -> name('dailies.edit');
Route::put('/daily/update/{id}', [DapController::class, 'update'])->name('dailies.update');
Route::delete('/daily/delete/{id}', [DapController::class, 'destroy'])->name('dailies.destroy');

// Route::get('posts', [PostController::class, 'index']);
// Route::get('posts/create', [PostController::class, 'create']);
// Route::get('posts/{id}', [PostController::class, 'show']);
// Route::post('posts', [PostController::class, 'store']);
// Route::get('posts/{id}/edit', [PostController::class, 'edit']);
// Route::patch('posts/{id}', [PostController::class, 'update']);
// Route::delete('posts/{id}', [PostController::class, 'destroy']);


// import json to sqlite
Route::get('/import-divisi', [DivisiController::class, 'import']);
Route::get('/import-user', [UserController::class, 'import']);
Route::get('/import-group', [GroupController::class, 'import']);
Route::get('/import-jabatan', [JabatanController::class, 'import']);
Route::get('/import-daily', [DailyController::class, 'import']);
Route::get('/import-report', [ReportController::class, 'import']);
Route::get('/import-tugas', [TugasController::class, 'import']);
