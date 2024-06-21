<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
                    'category_id' => $data->category_id,
                    'category_name' => $data->category_name,
                    'category_description' => $data->category_description,
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
