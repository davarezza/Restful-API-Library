<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;

class PublisherController extends Controller
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
        $publishers = Publisher::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Publishers found',
            'data' => PublisherResource::collection($publishers),
            'meta' => [
                'total' => $publishers->total(),
                'per_page' => $publishers->perPage(),
                'current_page' => $publishers->currentPage(),
                'last_page' => $publishers->lastPage(),
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PublisherRequest $request)
    {
        $validated = $request->validated();

        $publisher = Publisher::createPublisher($validated);

        return response()->json([
            'success' => true,
            'message' => 'Publisher created successfully',
            'data' => new PublisherResource($publisher),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publisher = Publisher::findPublisher($id);

        if (!$publisher) {
            return response()->json([
                'success' => false,
                'message' => 'Publisher not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Publisher found',
            'data' => new PublisherResource($publisher),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PublisherRequest $request, string $id)
    {
        $validated = $request->validated();

        $publisher = Publisher::updatePublisher($id, $validated);

        if (!$publisher) {
            return response()->json([
                'success' => false,
                'message' => 'Publisher not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Publisher updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publisher = Publisher::findPublisher($id);

        if (!$publisher) {
            return response()->json([
                'success' => false,
                'message' => 'Publisher not found',
            ], 404);
        }

        $publisher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Publisher deleted successfully',
        ], 200);
    }
}
