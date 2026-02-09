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
    public $adminUrl;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->siteName = Setting::get('site_name', config('app.name'));
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
        return new Content(
            view: 'emails.contact-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
