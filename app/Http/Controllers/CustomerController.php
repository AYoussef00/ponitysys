<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('customers.index');
    }

    public function show($id)
    {
        return view('customers.show');
    }

    public function edit($id)
    {
        return view('customers.edit');
    }

    public function update(Request $request, $id)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('customers.index');
    }
}
