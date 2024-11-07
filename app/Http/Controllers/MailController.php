<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Contact;
    use App\Models\SentEmail;
    use App\Models\UploadedFile;
    use App\Mail\SendEmail;
    use App\Models\Invoice;
    use Barryvdh\DomPDF\Facade\Pdf;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Log;

    class MailController extends Controller
    {
        /**
         * Show the form for sending an email.
         */
        public function create(Request $request)
        {
            $contacts = Contact::all();
            $uploadedFiles = UploadedFile::all();

            $invoice = null;
            if ($request->has('invoice_id')) {
                $invoice = Invoice::findOrFail($request->input('invoice_id'));
            }

            // Fetch all invoices to allow selection when not sending from a specific invoice
            $invoices = Invoice::all();

            return view('send_email', compact('contacts', 'uploadedFiles', 'invoice', 'invoices'));
        }

        /**
         * Handle sending the email.
         */
        public function send(Request $request)
        {
            // Log the start of the process
            Log::info('Starting send email process.');

            // Log all inputs
            Log::info('Request All:', $request->all());

            // Validate the request
            $request->validate([
                'recipients' => 'required|array',
                'recipients.*' => 'email',
                'subject' => 'required|string|max:255',
                'body' => 'required|string',
                'alt_body' => 'nullable|string',
                'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png',
                'existing_attachments.*' => 'nullable|string|exists:uploaded_files,path',
                'invoice_id' => 'nullable|exists:invoices,id',
                'remove_after_send' => 'sometimes|boolean',
            ]);

            $attachments = [];

            // Handle new file attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Generate a unique filename
                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Store the file in 'local' disk under 'attachments' directory
                    $path = $file->storeAs('attachments', $filename, 'local');

                    if ($path) {
                        // Save the file information to the database
                        $fileRecord = UploadedFile::create([
                            'name' => $file->getClientOriginalName(),
                            'path' => $path,
                        ]);

                        // Add the file to the email attachments array
                        $attachments[] = [
                            'path' => Storage::disk('local')->path($path),
                            'name' => $file->getClientOriginalName(),
                        ];

                        // Log the processed attachment
                        Log::info('Processed attachment:', ['path' => $path, 'name' => $file->getClientOriginalName()]);
                    } else {
                        Log::error('Failed to store attachment:', ['originalName' => $file->getClientOriginalName()]);
                    }
                }
            } else {
                Log::info('No new attachments found.');
            }

            // Handle existing attachments
            if ($request->input('existing_attachments')) {
                foreach ($request->input('existing_attachments') as $existingPath) {
                    Log::info('Processing existing attachment: ' . $existingPath);
                    $attachments[] = [
                        'path' => Storage::disk('local')->path($existingPath),
                        'name' => basename($existingPath),
                    ];
                }
            }

            // Handle invoice attachment if invoice_id is provided
            if ($request->input('invoice_id')) {
                $invoice = Invoice::find($request->input('invoice_id'));
                if ($invoice) {
                    // Generate the PDF for the invoice
                    $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

                    // Define a temporary path to save the PDF
                    $tempPath = storage_path('app/temp_invoice_' . $invoice->id . '.pdf');

                    // Save the PDF to the temporary path
                    $pdf->save($tempPath);

                    // Add the invoice PDF to the attachments
                    $attachments[] = [
                        'path' => $tempPath,
                        'name' => 'Invoice_' . $invoice->invoice_number . '.pdf',
                    ];

                    // Automatically add the contact's email as a recipient
                    $contactEmail = $invoice->contact->email;
                    if (!in_array($contactEmail, $request->input('recipients'))) {
                        $request->merge([
                            'recipients' => array_merge($request->input('recipients'), [$contactEmail]),
                        ]);
                    }
                }
            }

            // Log the final attachments array
            Log::info('Final attachments array:', $attachments);

            // Send the email using the Mailable
            try {
                Mail::to($request->input('recipients'))->send(new SendEmail(
                    $request->input('subject'),
                    $request->input('body'),
                    $request->input('alt_body'),
                    $attachments
                ));

                // Save the sent email details to the database
                SentEmail::create([
                    'recipients' => $request->input('recipients'),
                    'subject' => $request->input('subject'),
                    'body' => $request->input('body'),
                    'alt_body' => $request->input('alt_body'),
                    'attachments' => array_map(function($attachment) {
                        return [
                            'path' => $attachment['path'],
                            'name' => $attachment['name']
                        ];
                    }, $attachments),
                ]);

                // Delete the temporary invoice PDF if it was created
                if ($request->input('invoice_id') && isset($tempPath)) {
                    @unlink($tempPath);
                }

                // Remove the invoice after sending if the checkbox was selected

                Log::info('Email successfully sent and saved to database.');
                return redirect(url()->previousPath())->with('success', 'Email byl úspěšně odeslán.');
            } catch (\Exception $e) {
                Log::error('Mail Sending Error:', ['error' => $e->getMessage()]);
                return redirect(url()->previousPath())->with('error', 'Při odesílání emailu došlo k chybě: ' . $e->getMessage());
            }
        }

        /**
         * Display a list of sent emails.
         */
        public function sentEmails()
        {
            $sentEmails = SentEmail::orderBy('created_at', 'desc')->paginate(20);
            return view('sent_emails', compact('sentEmails'));
        }

        /**
         * Display email statistics.
         */
        public function emailStatistics(Request $request)
        {
            $startDate = $request->input('start_date', now()->addDays(-10)->toDateString());
            $endDate = $request->input('end_date', now()->addDay(10)->toDateString());

            $statistics = SentEmail::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return view('email_statistics', compact('statistics', 'startDate', 'endDate'));
        }
    }
