<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'message' => 'Daftar buku berhasil diambil',
            'data' => BookResource::collection($books),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $book = Book::create([
            'title' => $request->title,
        ]);

        return response()->json([
            'message' => 'Buku berhasil dibuat',
            'data' => new BookResource($book),
        ], 201);
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Buku berhasil diambil',
            'data' => new BookResource($book),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
        ]);

        $book->update($request->only('title'));

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data' => new BookResource($book),
        ]);
    }

    public function destroy(string $id)
    {
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}