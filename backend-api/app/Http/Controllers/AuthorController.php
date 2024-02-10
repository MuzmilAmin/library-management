<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::select('id','first_name','last_name')->paginate(10);
        return response()->json($authors);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50|string',
            'last_name' => 'required|max:50|string',
            ]);
        $new_author = new Author();
        $new_author->first_name = ucfirst($request->first_name);
        $new_author->last_name = ucfirst($request->last_name);
        if($new_author->save()){
            return response()->json([
                'message' => 'Author added successfully',
                'author' => $new_author
            ],200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return response()->json($author);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'first_name' => 'required|max:50|string',
            'last_name' => 'required|max:50|string',
            ]);
        $author->first_name = ucfirst($request->first_name);
        $author->last_name = ucfirst($request->last_name);
        if($author->save()){
            return response()->json([
                'message' => 'Author updated successfully',
                'author' => $author
            ],200);
            
        }
        return response()->json(['message' => 'Something went wrong'],500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if($author->delete()){
            return response()->json(['message' => 'Author deleted successfully'], 200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
