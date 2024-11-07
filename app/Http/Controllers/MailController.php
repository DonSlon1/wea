<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Contact;
    use App\Models\SentEmail;
    use App\Models\UploadedFile;
    use App\Mail\SendEmail;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Log;

    class MailController extends Controller
    {
        /**
         * Zobrazí formulář pro odeslání emailu
         */
        public function create()
        {
            $contacts = Contact::all();
            $uploadedFiles = UploadedFile::all();
            return view('send_email', compact('contacts', 'uploadedFiles'));
        }

        /**
         * Zpracuje odeslání emailu
         */
        public function send(Request $request)
        {
            // Logování začátku metody
            Log::info('Starting send email process.');

            // Logování všech vstupů
            Log::info('Request All:', $request->all());

            // Logování příloh
            //Log::info('Attachments Files:', $request->file('attachments') ? $request->file('attachments')->toArray() : []);

            // Validace formuláře
            $request->validate([
                'recipients' => 'required|array',
                'recipients.*' => 'email',
                'subject' => 'required|string|max:255',
                'body' => 'required|string',
                'alt_body' => 'nullable|string',
                'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048',
                'existing_attachments.*' => 'nullable|string|exists:uploaded_files,path',
            ]);

            // Zpracování nových příloh
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Logování zpracovaného přílohu
                    Log::info('Processing attachment:', ['name' => $file->getClientOriginalName()]);

                    // Uložení souboru
                    $path = $file->store('attachments');

                    // Uložení informace o souboru do databáze
                    $fileRecord = UploadedFile::create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                    ]);

                    // Přidání souboru do pole příloh pro email
                    $attachments[] = [
                        'path' => storage_path('app/' . $path),
                        'name' => $file->getClientOriginalName(),
                    ];

                    // Logování cesty a jména přílohy
                    Log::info('Stored attachment:', ['path' => 'storage/app/' . $path, 'name' => $file->getClientOriginalName()]);
                }
            } else {
                Log::info('No new attachments found.');
            }

            // Zpracování existujících příloh
            if ($request->input('existing_attachments')) {
                foreach ($request->input('existing_attachments') as $existingPath) {
                    Log::info('Processing existing attachment: ' . $existingPath);
                    $attachments[] = [
                        'path' => storage_path('app/' . $existingPath),
                        'name' => basename($existingPath),
                    ];
                }
            }

            // Logování finálního pole příloh
            Log::info('Final attachments array:', $attachments);

            // Odeslání emailu pomocí Mailable
            try {
                Mail::to($request->input('recipients'))->send(new SendEmail(
                    $request->input('subject'),
                    $request->input('body'),
                    $request->input('alt_body'),
                    $attachments
                ));

                // Uložení do databáze
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

                Log::info('Email successfully sent and saved to database.');
                return redirect()->back()->with('success', 'Email byl úspěšně odeslán.');
            } catch (\Exception $e) {
                Log::error('Mail Sending Error:', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Při odesílání emailu došlo k chybě: ' . $e->getMessage());
            }
        }

        /**
         * Zobrazí seznam odeslaných emailů
         */
        public function sentEmails()
        {
            $sentEmails = SentEmail::orderBy('created_at', 'desc')->paginate(20);
            return view('sent_emails', compact('sentEmails'));
        }

        /**
         * Zobrazí statistiku odeslaných emailů
         */
        public function emailStatistics(Request $request)
        {
            $startDate = $request->input('start_date', now()->subMonth()->toDateString());
            $endDate = $request->input('end_date', now()->toDateString());

            $statistics = SentEmail::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return view('email_statistics', compact('statistics', 'startDate', 'endDate'));
        }
    }
