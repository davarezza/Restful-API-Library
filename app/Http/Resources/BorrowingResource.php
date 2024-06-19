<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'borrowing_id' => $this->borrowing_id,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'email' => $this->user->email,
            ],
            'borrowing_isreturned' => $this->borrowing_isreturned,
            'borrowing_notes' => $this->borrowing_notes,
            'borrowing_fine' => $this->borrowing_fine,
        ];
    }
}
