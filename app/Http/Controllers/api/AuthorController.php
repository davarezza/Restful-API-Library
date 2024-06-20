<?php

namespace App\Http\Controllers\API;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Author::all();

        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => AuthorResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|max:150',
            'author_description' => 'max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Author::create($request->all());

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
        $data = Author::find($id);

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
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|max:150',
            'author_description' => 'max:150',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Author::find($id);
    
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
            ], 404);
        }
    
        $data->update($request->all());
    
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
        $data = Author::find($id);

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
