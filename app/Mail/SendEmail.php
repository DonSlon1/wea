<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class SendEmail extends Mailable
    {
        use Queueable, SerializesModels;

        public $subjectLine;
        public $htmlBody;
        public $plainBody;
        public $attachments;

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
            $this->attachments = $attachments;
        }

        /**
         * Sestaví zprávu.
         *
         * @return $this
         */
        public function build()
        {
            $email = $this->subject($this->subjectLine)
                ->view('emails.send')
                ->with('body', $this->htmlBody);

            // Přidání alternativního textu, pokud je poskytnut
            if ($this->plainBody) {
                $email->text('emails.send_plain')->with(['altBody' => $this->plainBody]);
            }

            // Přidání příloh
            foreach ($this->attachments as $attachment) {
                if (isset($attachment['path']) && isset($attachment['name'])) {
                    $email->attach($attachment['path'], [
                        'as' => $attachment['name'],
                        'mime' => mime_content_type($attachment['path']),
                    ]);
                }
            }

            return $email;
        }
    }
