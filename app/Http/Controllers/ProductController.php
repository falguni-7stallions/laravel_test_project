<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);
        $product = new product();
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Get original filename without extension
            $file_extension = $file->getClientOriginalExtension(); // Get original file extension

            // Create a unique filename by appending a unique ID to the original name
            $filename = $originalName . '_' . uniqid() . '.' . $file_extension;
            $file->move('uploads/products/', $filename);
            $product->image = $filename;
        }

        $product->save();
        return redirect('products')->with('success', 'New Product Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(product $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $products, int $id)
    {
        $product = product::findOrFail($id);
        return view('products.form', compact('product', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $products, int $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);
        $product = product::find($id);
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Get the original filename
            $file_extension = $file->getClientOriginalExtension(); // Get the file extension

            $filename = $originalName . '_' . uniqid() . '.' . $file_extension;
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image)); // Delete the old image file
            }

            $file->move('uploads/products/', $filename);
            $product->image = $filename;
        }

        $product->update();

        return redirect('products')->with('success', 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $products, int $id)
    {
        $product = product::find($id);
        if ($id){
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image)); // Delete the old image file
            }
            $product->delete();
            return redirect('products')->with('success', 'Product Deleted');
        }
    }
    public function viewProducts()
    {
        $products = product::all();
        if (auth()->check()) {
            $userId = auth()->id();

            // Fetch the product IDs from the wishlist for the logged-in user
            $wishlistItems = Wishlist::where('user_id', $userId)
                ->pluck('product_id')
                ->toArray();
        }
        return view('products.view-products', [
            'products' => $products,
            'wishlistItems' => $wishlistItems,
        ]);
    }
    public function getProduct($id)
    {
        $product = product::findOrFail($id);

        // You can return only the fields you need
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => asset('uploads/products/' . $product->image),
        ]);
    }

}
