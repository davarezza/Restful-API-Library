<?php

namespace App\Http\Controllers\API;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowingRequest;
use App\Http\Resources\BorrowingCollection;
use App\Http\Resources\BorrowingResource;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Borrowing::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Borrowing found',
            'data' => new BorrowingCollection($data),
            // 'data' => BorrowingResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowingRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            DB::beginTransaction();
    
            $borrowing = Borrowing::create($validatedData);
    
            foreach ($validatedData['details'] as $detail) {
                BorrowingDetail::create([
                    'detail_borrowing_id' => $borrowing->borrowing_id,
                    'detail_book_id' => $detail['book_id'],
                    'detail_quantity' => $detail['quantity'],
                ]);
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Borrowing created successfully',
                'data' => new BorrowingResource($borrowing),
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
        $data = Borrowing::findBorrowById($id);

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
    
            $borrowing = Borrowing::findBorrowById($id);
            $borrowing->update($request->all());
    
            BorrowingDetail::where('detail_borrowing_id', $borrowing->borrowing_id)->delete();
            foreach ($request->input('details') as $detail) {
                BorrowingDetail::create([
                    'detail_borrowing_id' => $borrowing->borrowing_id,
                    'detail_book_id' => $detail['book_id'],
                    'detail_quantity' => $detail['quantity'],
                ]);
            }
    
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
        try {
            DB::beginTransaction();
    
            $data = Borrowing::findBorrowById($id);
    
            if (!$data) {
                return response()->json([
                    'message' => 'Borrowing not found',
                ], 404);
            }
    
            $data->delete();
    
            DB::commit();
    
            return response()->json([
                'message' => 'Borrowing deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'message' => 'Failed to delete borrowing: ' . $e->getMessage(),
            ], 500);
        }
    }
}
