<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Plain data — no model serialization to avoid ModelNotFoundException
     * if the Contact is deleted between dispatch and worker processing.
     */
    public function __construct(
        public string $contactName,
        public string $contactEmail,
        public string $originalSubject,
        public string $originalMessage,
        public string $replyMessage,
        public string $subjectLine,
        public array $branding = []
    ) {}

    public static function fromContact(
        Contact $contact,
        string $replyMessage,
        string $subjectLine,
        array $branding = []
    ): self {
        return new self(
            contactName: $contact->name,
            contactEmail: $contact->email,
            originalSubject: $contact->subject,
            originalMessage: $contact->message,
            replyMessage: $replyMessage,
            subjectLine: $subjectLine,
            branding: $branding
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
            to: [$this->contactEmail]
        );
    }

    public function content(): Content
    {
        // Pass a stdClass that mimics the Contact API expected by the email
        // template, but without coupling to the Eloquent model lifecycle.
        $contact = (object) [
            'name' => $this->contactName,
            'email' => $this->contactEmail,
            'subject' => $this->originalSubject,
            'message' => $this->originalMessage,
        ];

        return new Content(
            view: 'emails.contact-reply',
            with: [
                'contact' => $contact,
                'replyMessage' => $this->replyMessage,
                'siteName' => $this->branding['siteName'] ?? config('app.name'),
                'logo' => $this->branding['logo'] ?? null,
                'hasLogo' => $this->branding['hasLogo'] ?? false,
                'contactEmail' => $this->branding['contactEmail'] ?? null,
                'contactPhone' => $this->branding['contactPhone'] ?? null,
                'contactAddress' => $this->branding['contactAddress'] ?? null,
                'socialFacebook' => $this->branding['socialFacebook'] ?? null,
                'socialInstagram' => $this->branding['socialInstagram'] ?? null,
                'socialTwitter' => $this->branding['socialTwitter'] ?? null,
            ]
        );
    }

    /**
     * Called by Laravel queue worker on permanent failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('ContactReplyMail failed', [
            'recipient' => $this->contactEmail,
            'error' => $exception->getMessage(),
        ]);
    }
}
