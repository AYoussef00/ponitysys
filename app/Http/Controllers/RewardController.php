<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        // جلب المكافآت الخاصة بالمستخدم (الشركة) الحالي فقط
        $rewards = Reward::where('user_id', auth()->id())->get();
        return view('rewards.index', compact('rewards'));
    }

    public function create()
    {
        return view('rewards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,draft',
            'expires_at' => 'nullable|date',
        ]);
        $validated['user_id'] = auth()->id(); // ربط المكافأة بالمستخدم (الشركة) الحالي
        Reward::create($validated);
        return redirect()->route('rewards.index')->with('success', 'تمت إضافة المكافأة بنجاح');
    }

    public function show($id)
    {
        return view('rewards.show');
    }

    public function edit($id)
    {
        return view('rewards.edit');
    }

    public function update(Request $request, $id)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('rewards.index');
    }

    public function destroy($id)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('rewards.index');
    }
}
