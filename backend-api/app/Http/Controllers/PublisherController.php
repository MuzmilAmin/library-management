<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::select('id','name')->paginate(10);
        return response()->json($publishers);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:publishers,name|max:255|string',
            ],[
                'name.unique' => 'Publisher already exists'
                ]);
                $new_publisher = new Publisher();
                $new_publisher->name = ucfirst($request->name);
                if($new_publisher->save()){
                    return response()->json([
                        'message' => 'Publisher added successfully',
                        'publisher' => $new_publisher
                    ],200);
                }
                return response()->json(['message' => 'Something went wrong'], 500);    
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return response()->json($publisher);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|unique:publishers,name,'.$publisher->id.'|max:255|string',
            ],[
                'name.unique' => 'Publisher already exists'
                ]);
                $publisher->name = ucfirst($request->name);
                if($publisher->save()){
                    return response()->json([
                        'message' => 'Publisher updated successfully',
                        'publisher' => $publisher
                    ],200);
                }
                return response()->json(['message' => 'Something went wrong'], 500);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        if($publisher->delete()){
            return response()->json([
                'message' => 'Publisher deleted successfully',
                'publisher' => $publisher
            ],200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
