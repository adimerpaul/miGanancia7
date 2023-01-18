<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller{
    public function index(Request $request){
        return Category::where('shop_id', $request->user()->shop_id)->get();
    }
    public function show(Category $category){ return $category; }
    public function store(Request $request){
        Category::create($request->all());
        $categories = Category::where('shop_id', $request->shop_id)->get();
        return $categories;
    }
    public function update(Request $request, Category $category){ $category->update($request->all()); return $category; }
    public function destroy(Category $category){ $category->delete(); return response()->json(null, 204); }
}
