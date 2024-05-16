<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = Category::find($this->category_id);
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'file'        => Storage::url($this->file),
            'category_id' => new CategoryResource($category),
            'tags' => TagResource::collection($this->whenLoaded('tags')), // Load and include tags
        ];
    }
}
