<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $siteName;
    public $logo;
    public $contactEmail;
    public $contactPhone;
    public $contactAddress;
    public $socialFacebook;
    public $socialInstagram;
    public $socialTwitter;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->siteName = Setting::get('site_name', config('app.name'));
        $this->logo = Setting::get('site_logo') ? asset('storage/' . Setting::get('site_logo')) : null;
        $this->contactEmail = Setting::get('contact_email');
        $this->contactPhone = Setting::get('contact_phone');
        $this->contactAddress = Setting::get('contact_address');
        $this->socialFacebook = Setting::get('social_facebook');
        $this->socialInstagram = Setting::get('social_instagram');
        $this->socialTwitter = Setting::get('social_twitter');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih Telah Menghubungi Kami - ' . $this->siteName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-auto-reply',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
