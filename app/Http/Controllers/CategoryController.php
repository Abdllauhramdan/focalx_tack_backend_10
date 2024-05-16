<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        $categories = Category::all();
        return $this->customeResponse(CategoryResource::collection($categories),"Done",200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null,"Server error",500);
    }
}

public function store(StoreCategoryRequest $request)
{
    try {
        $category = Category::create([
            'name' =>$request->name,
        ]);
        return $this->customeResponse(new CategoryResource($category), 'Created', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null,"Server error",500);
    }
}

public function show(Category $category)
{
    try {
        $category->load('documents');
        return $this->customeResponse(new CategoryResource($category), 'Done', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null,"Server error",500);
    }
}

public function update(StoreCategoryRequest $request, Category $category)
{
    try {
        $category->name = $request->input('name') ?? $category->name;
        $category->save();
        return $this->customeResponse(new CategoryResource($category), 'Updated', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null,"Server error",500);
    }
}

public function destroy(Category $category)
{
    try {
        $category->delete();
        return $this->customeResponse("", 'Deleted', 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return $this->customeResponse(null,"Server error",500);
    }
}
}
