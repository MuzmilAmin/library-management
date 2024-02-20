<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(10);
        return response()->json($books);
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255|string',
            'author' => 'required|max:255',
            'category' => 'required|max:255',
            'publisher' => 'required|max:255',
            'language' => 'required|max:255',
            'published_date' => 'required|date',
            'price' => 'required|numeric',
            'copies' => 'required|numeric',
        ]);
        $new_book = new Book();
        $new_book->title = ucfirst($request->title);
        $new_book->copies = $request->copies;
        $new_book->publisher_id = $request->publisher;
        $new_book->category_id = $request->category;
        $new_book->price = $request->price;
        if($new_book->save()){
            $new_book->authors()->attach($request->author);
            $new_book->languages()->attach($request->language);
            return response()->json([
                'message' => 'Book added successfully',
                'book' => $new_book
            ],200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);

        }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        
        $request->validate([
            'title' => 'required|max:255|string',
            'author' => 'required',
            'category' => 'required',
            'publisher' => 'required',
            'language' => 'required',
            'published_date' => 'required|date',
            'price' => 'required|numeric',
            'copies' => 'required|numeric',
            ]);
            $book->title = ucfirst($request->title);
            $book->copies = $request->copies;
            $book->publisher_id = $request->publisher;
            $book->category_id = $request->category;
            $book->price = $request->price;
            if($book->save()){
                $book->authors()->sync($request->author);
                $book->languages()->sync($request->language);
                return response()->json([
                    'message' => 'Book updated successfully',
                    'book' => $book
                ],200);
            }
            return response()->json(['message' => 'Something went wrong'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if($book->delete()){
            $book->authors()->detach();
            $book->languages()->detach();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
