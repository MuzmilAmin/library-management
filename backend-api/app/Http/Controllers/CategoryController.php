<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::select('id','name')->paginate(10);
        return response()->json($categories);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:50|alpha-dash',
        ],[
            'name.unique' => 'Category already exists'
        ]);
        $new_category = new Category();
        $new_category->name = ucfirst($request->name);
        if($new_category->save()){
            return response()->json([
                'message' => 'Category added successfully',
                'category' => $new_category
            ],200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id.'|max:50|alpha-dash',
        ],[
            'name.unique' => 'Category already exists'
        ]);
        
        $category->name = ucfirst($request->name);
        if($category->save()){
            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category
            ],200);
            
        }
        return response()->json(['message' => 'Something went wrong'],500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->delete()){
            return response()->json(['message' => 'Category deleted successfully'], 200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
