<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShelfCollection extends ResourceCollection
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
                    'shelf_id' => $data->shelf_id,
                    'shelf_name' => $data->shelf_name,
                    'shelf_position' => $data->shelf_position,
                ];
            }),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with(Request $request): array
    {
        return [
            'metadata' => [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'total_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total_data' => $this->resource->total(),
                'show_form' => $this->resource->firstItem(),
                'show_to' => $this->resource->lastItem(),
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
