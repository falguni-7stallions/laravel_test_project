<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = category::paginate(10);
        return view('category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required',
        ]);
        category::create($request->all());
        return redirect()->back()->with('success', 'New Category Added');
//        return redirect('category')->with('success', 'New Category Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        return response()->json($category);
//        $category = category::findOrFail($id);
//        return view('category.form', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $category = category::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'status' => 'required',
        ]);
        $category->update($request->all());
        return redirect()->back()->with('success', 'Category Updated');
//        return redirect('category')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $category = category::find($id);
        $category->delete();
        return redirect('category')->with('success', 'Category deleted');
    }
}
