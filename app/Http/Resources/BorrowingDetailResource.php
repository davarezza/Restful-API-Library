<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class BorrowingDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imgPath = 'img/books/' . $this->book->book_img;
        $img = File::exists(public_path($imgPath))? $imgPath : 'no image';

        return [
            'detail_id' => $this->detail_id,
            'detail_book_id' => [
                'book_id' => $this->book->book_id,
                'book_category_id' => $this->book->book_category_id,
                'book_shelf_id' => $this->book->book_shelf_id,
                'book_publisher_id' => $this->book->book_publisher_id,
                'book_author_id' => $this->book->book_author_id,
                'book_name' => $this->book->book_name,
                'book_isbn' => $this->book->book_isbn,
                'book_description' => $this->book->book_description,
                'book_img' => $img,
            ],
            'detail_borrowing_id' => [
                'borrowing_id' => $this->borrowing->borrowing_id,
                'borrowing_user_id' => $this->borrowing->borrowing_user_id,
                'borrowing_isreturned' => $this->borrowing->borrowing_isreturned,
                'borrowing_notes' => $this->borrowing->borrowing_notes,
                'borrowing_fine' => $this->borrowing->borrowing_fine,
            ],
            'detail_isreturned' => $this->detail_isreturned,
            'detail_notes' => $this->detail_notes,
            'detail_fine' => $this->detail_fine,
        ];
    }
}
