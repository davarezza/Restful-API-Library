<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();

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
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Category::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Category found',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Category::find($id);
    
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }
    
        $data->update($request->all());
    
        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
