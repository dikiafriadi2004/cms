<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\SettingsCache;
use App\Models\Contact;
use App\Services\TemplateService;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $settings = SettingsCache::all();

        if (($settings->get('contact_form_enabled', '0')) != '1') {
            return back()->with('error', 'Contact form is currently disabled.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        // Create contact record
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        // Send email notifications
        try {
            $recipientEmail = $settings->get('mail_username') 
                ?: $settings->get('contact_email');

            if ($recipientEmail) {
                Mail::to($contact->email)->queue(new \App\Mail\ContactAutoReply($contact));
                Mail::to($recipientEmail)->queue(new \App\Mail\ContactNotification($contact));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to queue contact form email: ' . $e->getMessage());
        }

        return back()->with('success', 'Terima kasih telah menghubungi kami! Kami akan segera merespons pesan Anda.');
    }
}
