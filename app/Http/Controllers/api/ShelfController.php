<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShelfRequest;
use App\Http\Resources\ShelfCollection;
use App\Http\Resources\ShelfResource;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isAdmin')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Shelf::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Shelves found',
            'data' => ShelfResource::collection($data),
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
    public function store(ShelfRequest $request)
    {
        $data = Shelf::createShelf($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Shelf created successfully',
            'data' => new ShelfResource($data),
        ], 201);
    }

    public function show(string $id)
    {
        $data = Shelf::findOrFailShelf($id);

        return response()->json([
            'success' => true,
            'message' => 'Shelf found',
            'data' => new ShelfResource($data),
        ], 200);
    }

    public function update(ShelfRequest $request, string $id)
    {
        $data = Shelf::findOrFailShelf($id);
        $data->updateShelf($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Shelf updated successfully',
        ], 200);
    }

    public function destroy(string $id)
    {
        $data = Shelf::findOrFailShelf($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shelf deleted successfully',
        ], 200);
    }
}
