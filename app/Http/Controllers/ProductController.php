<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // 1. Menampilkan semua produk (Read - Index)
    public function index()
    {
        $products = Product::paginate(10); // Menggunakan pagination
        return view('products.index', compact('products'));
    }

    // 2. Menampilkan form untuk membuat produk baru (Create - Formulir)
    public function create()
    {
        return view('products.create');
    }

    // 3. Menyimpan produk baru ke database (Create - Simpan)
    public function store(Request $request)
    {
        // Define the validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->route('products.create')
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, create the product
        Product::create($request->only(['name', 'description', 'price'])); // Use only() to get specific fields
        flash()->success(trans('product.created'));
        return redirect()->route('products.index');
    }

    // 4. Menampilkan detail produk (Read - Detail)
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // 5. Menampilkan form untuk mengedit produk (Update - Formulir)
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // 6. Memperbarui data produk di database (Update - Simpan)
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->route('products.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        // Temukan produk dan update
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        flash()->success(trans('product.updated'));
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // 7. Menghapus produk dari database (Delete)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        flash()->success(trans('product.deleted'));
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    // 8. Mengambil data harga produk
    public function getPrice(Request $request, $id)
    {

        $product = Product::where('id', $id)->first();
        if ($product == null) {
            return null;
        }

        return response()->json($product->price);
    }
}
