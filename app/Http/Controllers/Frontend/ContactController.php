<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\SettingsCache;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Services\TemplateService;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $settings = SettingsCache::all()->toArray();

        if (($settings['contact_form_enabled'] ?? '0') != '1') {
            abort(404);
        }

        $template = TemplateService::getCurrentTemplate();
        $viewPath = TemplateService::getView($template, 'contact');

        return view($viewPath, compact('settings'));
    }

    public function store(ContactFormRequest $request)
    {
        $settings = SettingsCache::all();

        if (($settings->get('contact_form_enabled', '0')) != '1') {
            return back()->with('error', 'Contact form is currently disabled.');
        }

        $validated = $request->validated();

        // Create contact record. ip_address is NEVER taken from user input
        // (it is not in $fillable on Contact model — set explicitly via forceFill).
        $contact = new Contact();
        $contact->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);
        $contact->ip_address = $request->ip();
        $contact->save();

        // Send email notifications
        try {
            $recipientEmail = $settings->get('mail_username')
                ?: $settings->get('contact_email');

            if ($recipientEmail) {
                Mail::to($contact->email)->queue(\App\Mail\ContactAutoReply::fromContact($contact));
                Mail::to($recipientEmail)->queue(\App\Mail\ContactNotification::fromContact($contact));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to queue contact form email: ' . $e->getMessage());
        }

        return back()->with('success', 'Terima kasih telah menghubungi kami! Kami akan segera merespons pesan Anda.');
    }
}
