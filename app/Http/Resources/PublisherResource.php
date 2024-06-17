<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'publisher_id' => $this->publisher_id,
            'publisher_name' => $this->publisher_name,
            'publisher_description' => $this->publisher_description,
        ];
    }
}
