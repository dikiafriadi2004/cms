<?php

namespace App\Mail;

use App\Models\Contact;
use App\Helpers\SettingsCache;
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
        $settings = SettingsCache::all();
        $this->siteName = $settings->get('site_name', config('app.name'));
        $this->logo = $settings->get('logo');
        $this->contactEmail = $settings->get('contact_email');
        $this->contactPhone = $settings->get('contact_phone');
        $this->contactAddress = $settings->get('contact_address');
        $this->socialFacebook = $settings->get('social_facebook');
        $this->socialInstagram = $settings->get('social_instagram');
        $this->socialTwitter = $settings->get('social_twitter');
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
