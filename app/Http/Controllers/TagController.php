<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        $tags = Tag::all();
        return $this->customeResponse(TagResource::collection($tags), "Done", 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function store(StoreTagRequest $request)
{
    try {
        $tag = Tag::create([
            'name' => $request->name,
        ]);
        return $this->customeResponse(new TagResource($tag), 'Created successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function show(Tag $tag)
{
    try {
        return $this->customeResponse(new TagResource($tag), 'Done', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function update(StoreTagRequest $request, Tag $tag)
{
    try {
        $tag->name = $request->input('name') ?? $tag->name;
        $tag->save();
        return $this->customeResponse(new TagResource($tag), 'Updated successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function destroy(Tag $tag)
{
    try {
        $tag->delete();
        return $this->customeResponse("", 'Deleted successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}
}
