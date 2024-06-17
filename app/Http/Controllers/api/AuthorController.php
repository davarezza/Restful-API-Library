<?php

namespace App\Http\Controllers\api;

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
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Author::create($request->all());

        return response()->json([
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
                'message' => 'Author not found',
            ], 404);
        }
    
        return response()->json([
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
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Author::find($id);
    
        if (!$data) {
            return response()->json([
                'message' => 'Author not found',
            ], 404);
        }
    
        $data->update($request->all());
    
        return response()->json([
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
                'message' => 'Author not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Author deleted successfully',
        ], 200);
    }
}
