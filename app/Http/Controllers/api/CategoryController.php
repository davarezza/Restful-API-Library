<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $data = Category::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Categories found',
            'data' => CategoryResource::collection($data),
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
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $data = Category::createCategory($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => new CategoryResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::findCategory($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Category found',
            'data' => new CategoryResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $validated = $request->validated();

        $data = Category::updateCategory($id, $validated);
    
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Category::findCategory($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
