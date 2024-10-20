<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    // Display a list of sales
    public function index()
    {
        $sales = Sale::orderBy('created_at', 'descending')->with('product')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    // Show the form for creating a new sale
    public function create()
    {
        // Get all products
        $products = Product::all();
        return view('sales.create', compact('products'));
    }


    // Store a newly created sale in storage
    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
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

        $product = Product::findOrFail($request->product_id);
        $total = $request->quantity * $request->price;

        Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'sale_date' => $request->sale_date,
            'total' => $total,
        ]);

        flash()->success(trans('sale.created'));
        return redirect()->route('sales.index');
    }

    // Show the form for editing the specified sale
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $products = Product::all(); // Fetch all products for the dropdown
        return view('sales.edit', compact('sale', 'products'));
    }

    // Update the specified sale in storage
    public function update(Request $request, $id)
    {
        // Define validation rules
        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->route('sales.edit', $id) // Redirect to the edit route instead
                ->withErrors($validator)
                ->withInput();
        }

        // Find the sale to update
        $sale = Sale::findOrFail($id);
        $product = Product::findOrFail($request->product_id);
        $total = $request->quantity * $request->price;

        // Update the sale record
        $sale->update([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'sale_date' => $request->sale_date,
            'total' => $total,
        ]);

        flash()->success(trans('sale.updated')); // Use the appropriate success message
        return redirect()->route('sales.index');
    }

    public function show($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    // Remove the specified sale from storage
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        flash()->success(trans('sale.deleted'));
        return redirect()->route('sales.index');
    }

    public function monthlySales(Request $request)
    {
        $year = $request->input('year', date('Y'));
        // Fetch your sales data from the database
        $monthlySales = Sale::select(
            DB::raw('YEAR(sale_date) as year'),
            DB::raw('MONTH(sale_date) as month'),
            'product_id',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(total) as total_sales')
        )
            ->whereYear('sale_date', '=', $year)
            ->groupBy('year', 'month', 'product_id')
            ->with('product')
            ->get();

        return response()->json($monthlySales);
    }
}
