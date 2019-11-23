<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Customer;


class CustomerController extends Controller
{

    public function index()
    {
        return Customer::with('products')->get();
    }

    public function show(Customer $customer)
    {
        return $customer->where('id', $customer->id)->with('products')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid|max:255',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
        ]);

        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'uuid' => 'required|uuid|max:255',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
        ]);
        $customer->update($request->all());
        return response()->json($customer, 200);
    }

    public function delete(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }


    public function show_form(Request $request)
    {
        $edit_mode = null;
        if(isset($request->id))
        {
            $edit_mode = 1;
            $customer = Customer::where('id',$request->id)->first();
            return view('customer.form', compact('edit_mode','customer'));
        }else{
            return view('customer.form');
        }
    }

    public function show_table()
    {
        $customers = Customer::with('products')->get();
        return view('customer.list', compact('customers'));
    }
}
