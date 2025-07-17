<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    public function index()
    {
        return view('redemptions.index');
    }

    public function create()
    {
        return view('redemptions.create');
    }

    public function store(Request $request)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('redemptions.index');
    }

    public function show($id)
    {
        return view('redemptions.show');
    }
}
