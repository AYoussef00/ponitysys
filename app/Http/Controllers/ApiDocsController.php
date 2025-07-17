<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ApiDocsController extends Controller
{
    public function downloadPdf()
    {
        // Generate PDF from the blade view
        $pdf = PDF::loadView('docs.api-guide');

        // Set paper size to A4
        $pdf->setPaper('a4');

        // Set font for better Arabic support
        $pdf->setOption(['defaultFont' => 'cairo']);

        // Return the PDF for download
        return $pdf->download('loyalty-system-api-guide.pdf');
    }
}
