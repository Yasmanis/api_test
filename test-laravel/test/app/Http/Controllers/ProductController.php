<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Customer;

class ProductController extends Controller
{

    public function index()
    {
        return  Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $request->validate([
            'issn' => 'required|uuid|max:255',
            'name' => 'required|string|max:255',
        ]);
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'issn' => 'required|uuid|max:255',
            'name' => 'required|string|max:255',
        ]);
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function delete(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function show_product(Request $request)
    {
        $edit_mode = null;
        $customers = Customer::all()->pluck('id');
        $reindex = [];
        $i = 1;
        foreach ($customers as $customer)
        {
            $reindex[$i] = $customer;
            $i++;
        }
        $customers = $reindex;

        if(isset($request->id))
        {
            $edit_mode = 1;
            $product = Product::where('id',$request->id)->with('customer')->first();
            return view('product.form', compact('edit_mode','product', 'customers'));
        }else{
            return view('product.form', compact('customers'));
        }
    }


    public function show_table()
    {
        $products = Product::all();
        return view('product.list', compact('products'));
    }
}
