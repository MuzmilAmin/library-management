<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::select('id','name')->paginate(10);
        return response()->json($languages);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:languages,name|max:50|alpha-dash',
        ],[
            'name.unique' => 'Language already exists'
        ]);
        $new_language = new Language();
        $new_language->name = ucfirst($request->name);
        if($new_language->save()){
            return response()->json([
                'message' => 'Language added successfully',
                'language' => $new_language
            ],200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        return response()->json($language);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required|unique:languages,name,'.$language->id.'|max:50|alpha-dash',
        ],[
            'name.unique' => 'Language already exists'
        ]);
        $language->name = ucfirst($request->name);
        if($language->save()){
            return response()->json([
                'message' => 'Language updated successfully',
                'language' => $language
            ],200);
            
        }
        return response()->json(['message' => 'Something went wrong'],500);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        if($language->delete()){
            return response()->json(['message' => 'Language deleted successfully'], 200);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
