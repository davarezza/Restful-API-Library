<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorCollection extends ResourceCollection
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
                    'author_id' => $data->author_id,
                    'author_name' => $data->author_name,
                    'author_description' => $data->author_description,
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
