<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Mail\Mailables\Attachment;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Log;

    class SendEmail extends Mailable
    {
        use Queueable, SerializesModels;

        public $subjectLine;
        public $htmlBody;
        public $plainBody;
        public $attachmentsArray;

        /**
         * Vytvoří novou instanci Mailable.
         *
         * @return void
         */
        public function __construct($subject, $htmlBody, $plainBody = null, $attachments = [])
        {
            $this->subjectLine = $subject;
            $this->htmlBody = $htmlBody;
            $this->plainBody = $plainBody;
            $this->attachmentsArray = $attachments;
        }

        /**
         * Sestaví zprávu.
         *
         * @return $this
         */
        public function build() : static
        {
            $email = $this->subject($this->subjectLine)
                ->markdown('emails.send')
                //->html('emails.send')
                ->with('body', $this->htmlBody);

            // Přidání alternativního textu, pokud je poskytnut
            if ($this->plainBody) {
                $email->text('emails.send_plain')->with('altBody', $this->plainBody);
            }

            // Přidání příloh
            foreach ($this->attachmentsArray as $attachment) {
                // Kontrola, zda příloha obsahuje klíče 'path' a 'name'
                if (isset($attachment['path']) && isset($attachment['name'])) {
                    // Kontrola existence souboru
                    if (file_exists($attachment['path'])) {
                        $attachment = Attachment::fromPath($attachment['path'])
                            ->as($attachment['name'])
                            ->withMime(mime_content_type($attachment['path']));
                        $email->attach($attachment);
                    } else {
                        Log::error('Attachment file does not exist:', ['path' => $attachment['path']]);
                    }
                } else {
                    Log::error('Attachment missing required keys:', ['attachment' => $attachment]);
                }
            }

            return $email;
        }
    }
