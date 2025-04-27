<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('product_name', 'like', "%{$search}%");
            })
            ->when($sort, function ($query, $sort) use ($direction) {
                if ($sort === 'category_name') {
                    return $query->join('categories', 'products.category_id', '=', 'categories.id')
                        ->orderBy('categories.category_name', $direction)
                        ->select('products.*');
                }
                return $query->orderBy($sort, $direction);
            })
            ->paginate(5)
            ->appends(['search' => $search, 'sort' => $sort, 'direction' => $direction]);

        return view('product.index', compact('products', 'sort', 'direction', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('category_name', 'asc')->get();

        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'product_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_price' => 'required|numeric|min:0',
            'product_qty' => 'required|numeric|min:0',
            'product_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('product_photo')) {
            $photoPath = $request->file('product_photo')->store('product_photos', 'public');
            $validatedData['product_photo'] = $photoPath;
        }

        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            Product::create($validatedData);
            Alert::success('Success', 'Product has been successfully created!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create product!');
        }

        return redirect()->route('product.index');
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
        $categories = Category::where('is_active', true)->orderBy('category_name', 'asc')->get();
        $product = Product::findOrFail($id);
        return view('product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'product_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_qty' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('product_photo')) {
            if ($product->product_photo && File::exists(public_path('storage/' . $product->product_photo))) {
                File::delete(public_path('storage/' . $product->product_photo));
            }
            $photoPath = $request->file('product_photo')->store('product_photos', 'public');
            $validatedData['product_photo'] = $photoPath;
        }

        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            $product->update($validatedData);
            Alert::success('Success', 'Product has been successfully updated!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update product!');
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->product_photo && File::exists(public_path('storage/' . $product->product_photo))) {
                File::delete(public_path('storage/' . $product->product_photo));
            }

            $product->delete();
            Alert::success('Success', 'Product has been successfully deleted!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete product!');
        }

        return redirect()->route('product.index');
    }
}
