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
        $this->logo = Setting::get('logo');
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
        // Check if using real domain (not ngrok or localhost)
        $isRealDomain = !str_contains(config('app.url'), 'ngrok') && 
                        !str_contains(config('app.url'), 'localhost') &&
                        !str_contains(config('app.url'), '127.0.0.1');
        
        return new Content(
            view: 'emails.contact-auto-reply',
            with: [
                'contact' => $this->contact,
                'siteName' => $this->siteName,
                'logo' => $this->logo,
                'hasLogo' => $isRealDomain && !empty($this->logo),
                'contactEmail' => $this->contactEmail,
                'contactPhone' => $this->contactPhone,
                'contactAddress' => $this->contactAddress,
                'socialFacebook' => $this->socialFacebook,
                'socialInstagram' => $this->socialInstagram,
                'socialTwitter' => $this->socialTwitter,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
