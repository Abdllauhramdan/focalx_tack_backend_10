<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        $documents = Document::with('tags')->get();
        return $this->customeResponse(DocumentResource::collection($documents), "Done", 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function store(StoreDocumentRequest $request)
{
    try {
        $storagePath = $this->storeFile($request->file);
        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file' => $storagePath,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tag_ids')) {
            $document->tags()->attach($request->input('tag_ids'));
        }
        return $this->customeResponse(new DocumentResource($document), 'Created successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function show(Document $document)
{
    try {
        $document->load('tags');
        return $this->customeResponse(new DocumentResource($document), 'Done', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function update(UpdateDocumentRequest $request, Document $document)
{
    try {
        if ($request->file) {
            $storagePath = $this->storeFile($request->file);
        } else {
            $storagePath = $document->file;
        }
        $document->title = $request->input('title') ?? $document->title;
        $document->description = $request->input('description') ?? $document->description;
        $document->category_id = $request->input('category_id') ?? $document->category_id;
        $document->file = $storagePath;
        if ($request->has('tag_ids')) {
            $document->tags()->sync($request->input('tag_ids'));
        }
        $document->save();
        return $this->customeResponse(new DocumentResource($document), 'Updated successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function destroy(Document $document)
{
    try {
        $document->delete();
        return $this->customeResponse("", 'Deleted successfully', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function download(Document $document)
{
    try {
        $document->downloadFile();
        $path = storage_path('app\public\\' . $document->file);
        return response()->download($path);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}

public function toggleLike(Document $document)
{
    try {
        if ($document) {
            $user = Auth::user();
            return $document->toggleLike($user);
        }
        return response()->json($document);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null, "Server error", 500);
    }
}
}
