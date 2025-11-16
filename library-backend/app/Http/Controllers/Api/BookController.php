<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * GET /api/books
     * Mengambil semua data buku
     */
    public function index()
    {
        try {
            $books = Book::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data buku berhasil diambil',
                'data' => $books
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/books
     * Menambahkan buku baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'jumlah_halaman' => 'required|integer|min:1',
            'kategori' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:20',
            'status' => 'nullable|in:Tersedia,Dipinjam'
        ],
        [
            'judul.required' => 'Judul buku wajib diisi',
            'pengarang.required' => 'Pengarang wajib diisi',
            'penerbit.required' => 'Penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'jumlah_halaman.required' => 'Jumlah halaman wajib diisi',
            'isbn.unique' => 'ISBN sudah terdaftar',
        ]);

        // Validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan buku baru
            $book = Book::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan',
                'data' => $book
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/books/{id}
     * Mengambil detail buku
     */
    public function show($id)
    {
        try {
            $book = Book::find($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail buku berhasil diambil',
                'data' => $book
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT/PATCH /api/books/{id}
     * Update buku
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        // Validasi update
        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'pengarang' => 'sometimes|required|string|max:255',
            'penerbit' => 'sometimes|required|string|max:255',
            'tahun_terbit' => 'sometimes|required|integer|min:1000|max:' . (date('Y') + 1),
            'jumlah_halaman' => 'sometimes|required|integer|min:1',
            'kategori' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $id . '|max:20',
            'status' => 'nullable|in:Tersedia,Dipinjam'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $book->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil diperbarui',
                'data' => $book
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/books/{id}
     */
    public function destroy($id)
    {
        try {
            $book = Book::find($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $book->delete();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
