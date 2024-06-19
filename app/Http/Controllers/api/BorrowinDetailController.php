<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowingDetailRequest;
use App\Http\Resources\BorrowingDetailResource;
use App\Models\BorrowingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowinDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BorrowingDetail::all();

        return response()->json([
            'message' => 'Data found',
            'data' => BorrowingDetailResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowingDetailRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = BorrowingDetail::create($request->all());

            DB::commit();

            return response()->json([
                'message' => 'Borrowing detail created successfully',
                'data' => new BorrowingDetailResource($data),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Failed to store borrowing detail: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BorrowingDetail::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Borrowing detail not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Borrowing found',
            'data' => new BorrowingDetail($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
    
            $borrowingDetail = BorrowingDetail::findOrFail($id);
            $borrowingDetail->update($request->all());
    
            DB::commit();
    
            return response()->json([
                'message' => 'Borrowing detail updated successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'message' => 'Failed to update borrowing detail: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = BorrowingDetail::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Borrowing detail not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Borrowing detail deleted successfully',
        ], 200);
    }
}
