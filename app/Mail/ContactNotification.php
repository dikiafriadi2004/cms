<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $siteName;
    public $logo;
    public $adminUrl;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->siteName = Setting::get('site_name', config('app.name'));
        $this->logo = Setting::get('logo');
        $this->adminUrl = url('/admin/contacts/' . $contact->id);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . $this->siteName . '] Pesan Baru dari ' . $this->contact->name,
        );
    }

    public function content(): Content
    {
        // Check if using real domain (not ngrok or localhost)
        $isRealDomain = !str_contains(config('app.url'), 'ngrok') && 
                        !str_contains(config('app.url'), 'localhost') &&
                        !str_contains(config('app.url'), '127.0.0.1');
        
        return new Content(
            view: 'emails.contact-notification',
            with: [
                'contact' => $this->contact,
                'siteName' => $this->siteName,
                'logo' => $this->logo,
                'hasLogo' => $isRealDomain && !empty($this->logo),
                'adminUrl' => $this->adminUrl,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
