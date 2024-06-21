<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BookController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware(middleware: 'isAdmin', except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Books found',
            'data' => BookResource::collection($data),
            'meta' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = Book::createBook($request->all());
    
        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => new BookResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Book::findBookById($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Book found',
            'data' => new BookResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $data = Book::findBookById($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found',
            ], 404);
        }

        $data->updateBook($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Book::findBookById($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found',
            ], 404);
        }

        $data->deleteBook();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully',
        ], 200);
    }
}
