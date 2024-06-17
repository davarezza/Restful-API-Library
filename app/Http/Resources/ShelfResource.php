<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShelfResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'shelf_id' => $this->shelf_id,
            'shelf_name' => $this->shelf_name,
            'shelf_position' => $this->shelf_position,
        ];
    }
}
