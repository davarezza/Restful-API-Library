<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShelfResource;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Shelf::all();

        return response()->json([
            'message' => 'Data found',
            'data' => ShelfResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shelf_name' => 'required|max:150',
            'shelf_position' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Shelf::create($request->all());

        return response()->json([
            'message' => 'Shelf created successfully',
            'data' => new ShelfResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Shelf::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Shelf not found',
            ], 404);
        }
    
        return response()->json([
            'message' => 'Shelf found',
            'data' => new ShelfResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'shelf_name' => 'required|max:150',
            'shelf_position' => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Shelf::find($id);
    
        if (!$data) {
            return response()->json([
                'message' => 'Shelf not found',
            ], 404);
        }
    
        $data->update($request->all());
    
        return response()->json([
            'message' => 'Shelf updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Shelf::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Shelf not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Shelf deleted successfully',
        ], 200);
    }
}
