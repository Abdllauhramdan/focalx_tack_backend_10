<?php

namespace App\Http\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $document = Document::find($this->commentable_id);
        return [
            'comment' => $this->comment,
            'commentable' => [
                'type' => class_basename($this->commentable_type),
                'details' => new DocumentResource($document), // Assuming commentable is a Document
            ],
        ];
    }
}
