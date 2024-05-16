<?php

namespace App\Http\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            // 'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}
