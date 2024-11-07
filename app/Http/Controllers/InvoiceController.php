<?php

    namespace App\Http\Controllers;

    use App\Models\Invoice;
    use App\Models\InvoiceItem;
    use App\Models\PdfTemplate;
    use Illuminate\Http\Request;
    use Barryvdh\DomPDF\Facade\Pdf;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

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
                'description' => 'nullable|string',
                'pdf_template_id' => 'required|exists:pdf_templates,id',
                'items' => 'required|array|min:1',
                'items.*.description' => 'required|string',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
            ]);

            try {
                DB::beginTransaction();

                // Create the invoice with amount = 0 initially
                $invoice = Invoice::create([
                    'invoice_number' => $request->invoice_number,
                    'invoice_date' => $request->invoice_date,
                    'description' => $request->description,
                    'pdf_template_id' => $request->pdf_template_id,
                    'amount' => 0,
                ]);

                $totalAmount = 0;

                // Create invoice items and calculate total amount
                foreach ($request->items as $itemData) {
                    $item = new InvoiceItem($itemData);
                    $invoice->items()->save($item);
                    $totalAmount += $item->quantity * $item->unit_price;
                }

                // Update the invoice amount
                $invoice->update(['amount' => $totalAmount]);

                DB::commit();

                return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating invoice: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage())->withInput();
            }
        }

        /**
         * Display the specified invoice.
         */
        public function show(Invoice $invoice)
        {
            $invoice->load('items', 'pdfTemplate');
            return view('invoices.show', compact('invoice'));
        }

        /**
         * Show the form for editing the specified invoice.
         */
        public function edit(Invoice $invoice)
        {
            $pdfTemplates = PdfTemplate::all();
            $invoice->load('items');
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
                'amount' => 'nullable|numeric', // This will be calculated
                'description' => 'nullable|string',
                'pdf_template_id' => 'required|exists:pdf_templates,id',
                'items' => 'required|array|min:1',
                'items.*.description' => 'required|string',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
            ]);

            // Update the invoice details
            $invoice->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'description' => $request->description,
                'pdf_template_id' => $request->pdf_template_id,
            ]);

            // Delete existing items
            $invoice->items()->delete();

            // Initialize total amount
            $totalAmount = 0;

            // Add updated invoice items
            foreach ($request->items as $itemData) {
                $item = new InvoiceItem($itemData);
                $invoice->items()->save($item);
                $totalAmount += $item->total;
            }

            // Update the total amount in the invoice
            $invoice->update(['amount' => $totalAmount]);

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
            $invoice->load('items', 'pdfTemplate');

            // Generate PDF using the selected template
            $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

            return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
        }
    }
