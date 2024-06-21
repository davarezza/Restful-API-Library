<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\File;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imgPath = 'img/books/' . $this->book_img;
        $img = File::exists(public_path($imgPath))? $imgPath : 'no image';

        return [
            'data' => $this->collection->transform(function ($data) {
                return [
                    'book_id' => $data->book_id,
                    'shelf' => [
                        'shelf_id' => $data->shelves->shelf_id,
                        'shelf_name' => $data->shelves->shelf_name,
                        'shelf_position' => $data->shelves->shelf_position,
                    ],
                    'publisher' => [
                        'publisher_id' => $data->publishers->publisher_id,
                        'publisher_name' => $data->publishers->publisher_name,
                        'publisher_description' => $data->publishers->publisher_description,
                    ],
                    'author' => [
                        'category_id' => $data->authors->author_id,
                        'category_name' => $data->authors->author_name,
                        'category_description' => $data->authors->author_description,
                    ],
                    'category' => [
                        'category_id' => $data->categories->category_id,
                        'category_name' => $data->categories->category_name,
                        'category_description' => $data->categories->category_description,
                    ],
                    'book_name' => $data->book_name,
                    'book_isbn' => $data->book_isbn,
                    'book_stock' => $data->book_stock,
                    'book_description' => $data->book_description,
                    'book_img' => 'books/img/' . $data->book_img,
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
