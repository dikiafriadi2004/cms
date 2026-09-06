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

class ContactNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public int $contactId,
        public string $contactName,
        public string $contactEmail,
        public string $contactSubject,
        public string $contactMessage,
        public ?string $contactPhone = null
    ) {}

    public static function fromContact(Contact $contact): self
    {
        return new self(
            contactId: $contact->id,
            contactName: $contact->name,
            contactEmail: $contact->email,
            contactSubject: $contact->subject,
            contactMessage: $contact->message,
            contactPhone: $contact->phone
        );
    }

    public function envelope(): Envelope
    {
        $settings = SettingsCache::all();
        $siteName = $settings->get('site_name', config('app.name'));

        return new Envelope(
            subject: '[' . $siteName . '] Pesan Baru dari ' . $this->contactName,
        );
    }

    public function content(): Content
    {
        $settings = SettingsCache::all();
        $appUrl = config('app.url');
        $isRealDomain = !str_contains($appUrl, 'ngrok')
            && !str_contains($appUrl, 'localhost')
            && !str_contains($appUrl, '127.0.0.1');

        $logo = $settings->get('logo');

        $contact = (object) [
            'id' => $this->contactId,
            'name' => $this->contactName,
            'email' => $this->contactEmail,
            'subject' => $this->contactSubject,
            'message' => $this->contactMessage,
            'phone' => $this->contactPhone,
        ];

        return new Content(
            view: 'emails.contact-notification',
            with: [
                'contact' => $contact,
                'siteName' => $settings->get('site_name', config('app.name')),
                'logo' => $logo,
                'hasLogo' => $isRealDomain && !empty($logo),
                'adminUrl' => url('/admin/contacts/' . $this->contactId),
            ]
        );
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ContactNotification failed', [
            'contact_id' => $this->contactId,
            'error' => $exception->getMessage(),
        ]);
    }
}
