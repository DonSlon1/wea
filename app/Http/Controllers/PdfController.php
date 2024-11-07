<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Barryvdh\DomPDF\Facade\Pdf; // Make sure to include this if you set up the facade

    class PdfController extends Controller
    {
        public function create()
        {
            $data = [
                'title' => 'Sample PDF Document',
                'date' => date('m/d/Y'),
                'content' => 'This is a sample PDF generated using Laravel and DOMPDF.'
            ];

            return view('pdf.create', compact('data'));
        }

        public function download()
        {
            $data = [
                'title' => 'Sample PDF Document',
                'date' => date('m/d/Y'),
                'content' => 'This is a sample PDF generated using Laravel and DOMPDF.'
            ];

            $pdf = PDF::loadView('pdf.document', $data);

            return $pdf->download('sample.pdf');
            // Or use return $pdf->stream('sample.pdf'); to stream in the browser
        }
    }
