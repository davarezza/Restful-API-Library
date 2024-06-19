<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::all();

        return response()->json([
            'message' => 'Data found',
            'data' => BookResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        try {
            DB::beginTransaction();

            // Upload and save image
            if ($request->hasFile('book_img')) {
                $file = $request->file('book_img');
                $imageName = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/books'), $imageName);
            } else {
                return response()->json([
                    'message' => 'Image file is required',
                ], 422);
            }

            // Create book record
            $data = Book::create($request->all());
            $data->book_img = $imageName;
            $data->save();

            DB::commit();

            return response()->json([
                'message' => 'Book created successfully',
                'data' => new BookResource($data),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Failed to store book: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Book::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Book found',
            'data' => new BookResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $data = Book::find($id);
    
        if (!$data) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    
        try {
            DB::beginTransaction();
    
            if ($request->hasFile('book_img')) {
                $oldImage = public_path('img/books/' . $data->book_img);
                if (File::exists($oldImage)) {
                    File::delete($oldImage);
                }
    
                $file = $request->file('book_img');
                $imageName = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/books'), $imageName);
                $data->book_img = $imageName;
            }
    
            $data->update($request->except('book_img'));
    
            DB::commit();
    
            return response()->json([
                'message' => 'Book updated successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'message' => 'Failed to update book: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Book::find($id);
    
        if (!$data) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    
        try {
            DB::beginTransaction();
    
            // Delete image file
            $imagePath = public_path('img/books/' . $data->book_img);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
    
            $data->delete();
    
            DB::commit();
    
            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'message' => 'Failed to delete book: ' . $e->getMessage(),
            ], 500);
        }
    }
}
