<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Publisher::all();

        return response()->json([
            'message' => 'Data found',
            'data' => PublisherResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'publisher_name' => 'required|max:150',
            'publisher_description' => 'max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = Publisher::create($request->all());

        return response()->json([
            'message' => 'Publisher created successfully',
            'data' => new PublisherResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Publisher::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Publisher not found',
            ], 404);
        }
    
        return response()->json([
            'message' => 'Publisher found',
            'data' => new PublisherResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'publisher_name' => 'required|max:150',
            'publisher_description' => 'max:150',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 422);
        }
    
        $data = Publisher::find($id);
    
        if (!$data) {
            return response()->json([
                'message' => 'Publisher not found',
            ], 404);
        }
    
        $data->update($request->all());
    
        return response()->json([
            'message' => 'Publisher updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Publisher::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Publisher not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Publisher deleted successfully',
        ], 200);
    }
}
