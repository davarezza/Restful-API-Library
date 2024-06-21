<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BorrowingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($data) {
                return [
                    'borrowing_id' => $data->borrowing_id,
                    'user' => [
                        'id' => $data->user->id,
                        'username' => $data->user->username,
                        'email' => $data->user->email,
                    ],
                    'details' => $data->details->transform(function ($detail) {
                        return [
                            'detail_id' => $detail->detail_id,
                            'detail_book_id' => $detail->detail_book_id,
                            'detail_quantity' => $detail->detail_quantity,
                        ];
                    }),
                    'borrowing_isreturned' => $data->borrowing_isreturned,
                    'borrowing_notes' => $data->borrowing_notes,
                    'borrowing_fine' => $data->borrowing_fine,
                ];
            }),
            'metadata' => [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'total_pages' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total_data' => $this->resource->total(),
                'links' => [
                    'prev_page_url' => $this->resource->previousPageUrl(),
                    'next_page_url' => $this->resource->nextPageUrl(),
                    'first_page_url' => $this->resource->url(1),
                    'last_page_url' => $this->resource->url($this->resource->lastPage()),
                ],
            ],
        ];
    }
}
