<?php

namespace App\Http\Controllers\API;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isAdmin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Author::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Categories found',
            'data' => AuthorResource::collection($data),
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
    public function store(AuthorRequest $request)
    {
        $validated = $request->validated();

        $data = Author::createAuthor($validated);

        return response()->json([
            'success' => true,
            'message' => 'Author created successfully',
            'data' => new AuthorResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Author::findAuthor($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Author found',
            'data' => new AuthorResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, string $id)
    {
        $validated = $request->validated();

        $data = Author::updateAuthor($id, $validated);
    
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Author::findAuthor($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully',
        ], 200);
    }
}
