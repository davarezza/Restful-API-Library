<?php

namespace App\Http\Controllers\api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:255',
            'author_description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Author::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Author created successfully',
            'data' => $data,
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
                'status' => false,
                'message' => 'Author not found',
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Author found',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:255',
            'author_description' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Author::find($id);
    
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Author not found',
            ], 404);
        }
    
        $data->update($request->all());
    
        return response()->json([
            'status' => true,
            'message' => 'Author updated successfully',
            'data' => $data,
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
                'status' => false,
                'message' => 'Author not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Author deleted successfully',
        ], 200);
    }
}
