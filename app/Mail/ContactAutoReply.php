<?php

namespace App\Mail;

use App\Helpers\SettingsCache;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactAutoReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $contactName,
        public string $contactEmail,
        public string $originalSubject,
        public string $originalMessage
    ) {}

    public static function fromContact(Contact $contact): self
    {
        return new self(
            contactName: $contact->name,
            contactEmail: $contact->email,
            originalSubject: $contact->subject,
            originalMessage: $contact->message
        );
    }

    public function envelope(): Envelope
    {
        $settings = SettingsCache::all();
        $siteName = $settings->get('site_name', config('app.name'));

        return new Envelope(
            subject: 'Terima Kasih Telah Menghubungi Kami - ' . $siteName,
        );
    }

    public function content(): Content
    {
        // Resolve settings inside content() (queue worker context) so values
        // reflect current settings, not a snapshot at dispatch time.
        $settings = SettingsCache::all();
        $appUrl = config('app.url');
        $isRealDomain = !str_contains($appUrl, 'ngrok')
            && !str_contains($appUrl, 'localhost')
            && !str_contains($appUrl, '127.0.0.1');

        $logo = $settings->get('logo');

        $contact = (object) [
            'name' => $this->contactName,
            'email' => $this->contactEmail,
            'subject' => $this->originalSubject,
            'message' => $this->originalMessage,
        ];

        return new Content(
            view: 'emails.contact-auto-reply',
            with: [
                'contact' => $contact,
                'siteName' => $settings->get('site_name', config('app.name')),
                'logo' => $logo,
                'hasLogo' => $isRealDomain && !empty($logo),
                'contactEmail' => $settings->get('contact_email'),
                'contactPhone' => $settings->get('contact_phone'),
                'contactAddress' => $settings->get('contact_address'),
                'socialFacebook' => $settings->get('social_facebook'),
                'socialInstagram' => $settings->get('social_instagram'),
                'socialTwitter' => $settings->get('social_twitter'),
            ]
        );
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ContactAutoReply failed', [
            'recipient' => $this->contactEmail,
            'error' => $exception->getMessage(),
        ]);
    }
}
