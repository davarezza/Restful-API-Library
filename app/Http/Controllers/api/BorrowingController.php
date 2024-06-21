<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowingRequest;
use App\Http\Resources\BorrowingCollection;
use App\Http\Resources\BorrowingResource;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Borrowings found',
            'data' => new BorrowingCollection($borrowings),
        ], 200);
    }

    public function store(BorrowingRequest $request)
    {
        $borrowing = Borrowing::storeWithDetails($request->validated());

        if ($borrowing) {
            return response()->json([
                'success' => true,
                'message' => 'Borrowing created successfully',
                'data' => new BorrowingResource($borrowing),
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to store borrowing',
        ], 500);
    }

    public function show(string $id)
    {
        $borrowing = Borrowing::findByIdWithDetails($id);

        if (!$borrowing) {
            return response()->json([
                'success' => false,
                'message' => 'Borrowing not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Borrowing found',
            'data' => new BorrowingResource($borrowing),
        ], 200);
    }

    public function update(BorrowingRequest $request, string $id)
    {
        $success = Borrowing::updateWithDetails($id, $request->validated());

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Borrowing updated successfully',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update borrowing',
        ], 500);
    }

    public function destroy(string $id)
    {
        $success = Borrowing::deleteById($id);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Borrowing deleted successfully',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete borrowing',
        ], 500);
    }
}
