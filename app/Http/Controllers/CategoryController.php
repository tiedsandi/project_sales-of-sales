<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('category_name', 'like', "%{$search}%");
        })->orderByDesc('id')->paginate(5);

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            Category::create($validatedData);
            Alert::success('Success', 'Category has been successfully created!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create category!');
        }

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            $category = Category::findOrFail($id);
            $category->update($validatedData);
            Alert::success('Success', 'Category has been successfully updated!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update category!');
        }

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            Alert::success('Success', 'Category has been successfully deleted!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete category!');
        }

        return redirect()->route('category.index');
    }
}
