<?php

    namespace App\Http\Controllers;

    use App\Models\PdfTemplate;
    use Illuminate\Http\Request;

    class PdfTemplateController extends Controller
    {
        /**
         * Display a listing of the PDF templates.
         */
        public function index()
        {
            $templates = PdfTemplate::paginate(10);
            return view('pdf_templates.index', compact('templates'));
        }

        /**
         * Show the form for creating a new PDF template.
         */
        public function create()
        {
            return view('pdf_templates.create');
        }

        /**
         * Store a newly created PDF template in storage.
         */
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'blade_template' => 'required|string',
            ]);

            PdfTemplate::create($request->all());

            return redirect()->route('pdf-templates.index')->with('success', 'PDF Template created successfully.');
        }

        /**
         * Display the specified PDF template.
         */
        public function show(PdfTemplate $pdfTemplate)
        {
            return view('pdf_templates.show', compact('pdfTemplate'));
        }

        /**
         * Show the form for editing the specified PDF template.
         */
        public function edit(PdfTemplate $pdfTemplate)
        {
            return view('pdf_templates.edit', compact('pdfTemplate'));
        }

        /**
         * Update the specified PDF template in storage.
         */
        public function update(Request $request, PdfTemplate $pdfTemplate)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'blade_template' => 'required|string',
            ]);

            $pdfTemplate->update($request->all());

            return redirect()->route('pdf-templates.index')->with('success', 'PDF Template updated successfully.');
        }

        /**
         * Remove the specified PDF template from storage.
         */
        public function destroy(PdfTemplate $pdfTemplate)
        {
            // Optionally, check if any invoices are using this template
            if ($pdfTemplate->invoices()->count() > 0) {
                return redirect()->route('pdf-templates.index')->with('error', 'Cannot delete template as it is in use.');
            }

            $pdfTemplate->delete();
            return redirect()->route('pdf-templates.index')->with('success', 'PDF Template deleted successfully.');
        }
    }
