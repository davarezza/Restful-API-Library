<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shelf_name' => 'required|string|max:255',
            'shelf_position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Shelf::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Shelf created successfully',
            'data' => $data,
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
                'status' => false,
                'message' => 'Shelf not found',
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Shelf found',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'shelf_name' => 'required|string|max:255',
            'shelf_position' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Shelf::find($id);
    
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Shelf not found',
            ], 404);
        }
    
        $data->update($request->all());
    
        return response()->json([
            'status' => true,
            'message' => 'Shelf updated successfully',
            'data' => $data,
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
                'status' => false,
                'message' => 'Shelf not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Shelf deleted successfully',
        ], 200);
    }
}
