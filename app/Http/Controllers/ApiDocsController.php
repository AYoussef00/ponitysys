<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocsController extends Controller
{
    public function show()
    {
        return view('docs.api-guide');
    }

    public function downloadPdf()
    {
        // يمكن إضافة منطق تحميل PDF هنا
        return response()->json(['message' => 'سيتم إضافة هذه الميزة قريباً']);
    }
}
