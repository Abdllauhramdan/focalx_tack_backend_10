<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        $comments = Comment::all();
        return $this->customeResponse(CommentResource::collection($comments), "Done", 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function store(CommentRequest $request, Document $document)
{
    try {
        $comment = $document->comments()->create([
            'comment' => $request->comment,
        ]);
        return $this->customeResponse(new CommentResource($comment), 'Created successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function show(Comment $comment)
{
    try {
        return $this->customeResponse(new CommentResource($comment), 'Done', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function update(CommentRequest $request, Comment $comment)
{
    try {
        $comment->comment = $request->input('comment') ?? $comment->comment;
        $comment->save();
        return $this->customeResponse(new CommentResource($comment), 'Updated successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function destroy(Comment $comment)
{
    try {
        $comment->delete();
        return $this->customeResponse("", 'Deleted successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}
}
