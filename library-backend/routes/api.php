<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes di sini akan dipanggil melalui URL:
|   http://localhost:8000/api/...
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes untuk Buku
Route::get('/books', [BookController::class, 'index']);       // Ambil semua buku
Route::post('/books', [BookController::class, 'store']);      // Tambah buku
Route::get('/books/{id}', [BookController::class, 'show']);   // Detail buku
Route::put('/books/{id}', [BookController::class, 'update']); // Update buku
Route::delete('/books/{id}', [BookController::class, 'destroy']); // Hapus buku
