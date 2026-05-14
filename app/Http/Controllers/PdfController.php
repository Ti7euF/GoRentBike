<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Dompdf\Dompdf;

class PdfController extends Controller
{
    public function export(Request $request) {
        $html = $request->input('html');
        $title = $request->input('title');

        $dompdf = new Dompdf();

        $fullHtml = "<html>
                        <head>
                            <meta charset='utf-8'>
                            <style>
                                body { font-family: sans-serif; font-size: 12px; }
                                h2 { margin-bottom: 15px; }
                                table { width: 100%; border-collapse: collapse; }
                                th, td { border: 1px solid #ccc; padding: 6px; }
                                th { background: #eee; }
                            </style>
                        </head>
                        <body>
                            <h2>{$title}</h2>
                            {$html}
                        </body>
                    </html>";
        
        $dompdf->loadHtml($fullHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream($title . '_GoRentBike.pdf');
    }
}
