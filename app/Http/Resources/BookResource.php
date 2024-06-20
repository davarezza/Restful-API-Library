<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imgPath = 'img/books/' . $this->book_img;
        $img = File::exists(public_path($imgPath))? $imgPath : 'no image';

        return [
            'book_id' => $this->book_id,
            'shelf' => [
                'shelf_id' => $this->shelves->shelf_id,
                'shelf_name' => $this->shelves->shelf_name,
                'shelf_position' => $this->shelves->shelf_position,
            ],
            'publisher' => [
                'publisher_id' => $this->publishers->publisher_id,
                'publisher_name' => $this->publishers->publisher_name,
                'publisher_description' => $this->publishers->publisher_description,
            ],
            'author' => [
                'category_id' => $this->authors->author_id,
                'category_name' => $this->authors->author_name,
                'category_description' => $this->authors->author_description,
            ],
            'category' => [
                'category_id' => $this->categories->category_id,
                'category_name' => $this->categories->category_name,
                'category_description' => $this->categories->category_description,
            ],
            'book_name' => $this->book_name,
            'book_isbn' => $this->book_isbn,
            'book_stock' => $this->book_stock,
            'book_description' => $this->book_description,
            'book_img' => $img,
        ];
    }
}
