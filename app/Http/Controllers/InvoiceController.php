<?php

    namespace App\Http\Controllers;

    use App\Models\Invoice;
    use App\Models\PdfTemplate;
    use Illuminate\Http\Request;
    use Barryvdh\DomPDF\Facade\Pdf;

    class InvoiceController extends Controller
    {
        /**
         * Display a listing of the invoices.
         */
        public function index()
        {
            $invoices = Invoice::with('pdfTemplate')->paginate(10);
            return view('invoices.index', compact('invoices'));
        }

        /**
         * Show the form for creating a new invoice.
         */
        public function create()
        {
            $pdfTemplates = PdfTemplate::all();
            return view('invoices.create', compact('pdfTemplates'));
        }

        /**
         * Store a newly created invoice in storage.
         */
        public function store(Request $request)
        {
            $request->validate([
                'invoice_number' => 'required|unique:invoices,invoice_number',
                'invoice_date' => 'required|date',
                'amount' => 'required|numeric',
                'description' => 'nullable|string',
                'pdf_template_id' => 'required|exists:pdf_templates,id',
            ]);

            Invoice::create($request->all());

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        }

        /**
         * Display the specified invoice.
         */
        public function show(Invoice $invoice)
        {
            return view('invoices.show', compact('invoice'));
        }

        /**
         * Show the form for editing the specified invoice.
         */
        public function edit(Invoice $invoice)
        {
            $pdfTemplates = PdfTemplate::all();
            return view('invoices.edit', compact('invoice', 'pdfTemplates'));
        }

        /**
         * Update the specified invoice in storage.
         */
        public function update(Request $request, Invoice $invoice)
        {
            $request->validate([
                'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoice->id,
                'invoice_date' => 'required|date',
                'amount' => 'required|numeric',
                'description' => 'nullable|string',
                'pdf_template_id' => 'required|exists:pdf_templates,id',
            ]);

            $invoice->update($request->all());

            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
        }

        /**
         * Remove the specified invoice from storage.
         */
        public function destroy(Invoice $invoice)
        {
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        }

        /**
         * Download the invoice as PDF.
         */
        public function download(Invoice $invoice)
        {
            $templateContent = $invoice->pdfTemplate->blade_template;

            // Use a temporary view to render the Blade template from the database
            $pdf = Pdf::loadHTML($this->renderBladeTemplate($templateContent, $invoice));

            return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
        }

        /**
         * Render Blade template content from string.
         */
        protected function renderBladeTemplate($templateContent, $invoice)
        {
            $view = new \Illuminate\View\Factory(
                app('view.engine.resolver'),
                app('view.finder'),
                app('events')
            );

            $blade = app('blade.compiler');

            // Compile the Blade template content
            $compiled = $blade->compileString($templateContent);

            // Create a temporary view
            ob_start();
            eval('?>' . $compiled);
            $html = ob_get_clean();

            // Pass the $invoice variable to the template
            return view()->make('temp', compact('html', 'invoice'))->render();
        }
    }
