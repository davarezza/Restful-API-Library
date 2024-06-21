<?php

namespace App\Http\Controllers\API;

use App\Models\Shelf;
use Illuminate\Http\Request;
use App\Http\Requests\ShelfRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShelfResource;
use App\Http\Resources\ShelfCollection;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ShelfController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware(middleware: 'isAdmin', except: ['index', 'show']),
        ];
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
            'data' => new ShelfCollection($data),
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
