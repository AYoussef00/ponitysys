<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function mobileIntegration()
    {
        return view('settings.mobile-integration');
    }

    public function updateCompany(Request $request)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('settings.index')->with('success', 'تم تحديث معلومات الشركة بنجاح');
    }

    public function updatePoints(Request $request)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('settings.index')->with('success', 'تم تحديث إعدادات النقاط بنجاح');
    }
}
