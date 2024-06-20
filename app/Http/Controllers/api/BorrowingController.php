<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowingRequest;
use App\Http\Resources\BorrowingResource;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Borrowing::all();

        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => BorrowingResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowingRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = Borrowing::create($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Borrowing created successfully',
                'data' => new BorrowingResource($data),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to store borrowing: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Borrowing::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Borrowing not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Borrowing found',
            'data' => new BorrowingResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BorrowingRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
    
            $borrowing = Borrowing::findOrFail($id);
            $borrowing->update($request->all());
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Borrowing updated successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to update borrowing: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Borrowing::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Borrowing not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Borrowing deleted successfully',
        ], 200);
    }
}
