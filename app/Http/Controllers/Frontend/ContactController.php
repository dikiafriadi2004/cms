<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        // Check if contact form is enabled
        $enabled = Setting::where('key', 'contact_form_enabled')->value('value');
        
        if ($enabled != '1') {
            abort(404);
        }

        // Get settings and menus
        $settings = Setting::pluck('value', 'key')->toArray();
        $headerMenu = \App\Models\Menu::where('location', 'header')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
        }])->first();
        $footerMenu = \App\Models\Menu::where('location', 'footer')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
        }])->first();

        // Get template view path
        $template = TemplateService::getCurrentTemplate();
        $viewPath = TemplateService::getView($template, 'contact');

        return view($viewPath, compact('settings', 'headerMenu', 'footerMenu'));
    }

    public function store(Request $request)
    {
        // Check if contact form is enabled
        $enabled = Setting::where('key', 'contact_form_enabled')->value('value');
        
        if ($enabled != '1') {
            return back()->with('error', 'Contact form is currently disabled.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
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
            // Get recipient email (use mail_username as primary recipient)
            $recipientEmail = Setting::where('key', 'mail_username')->value('value');
            
            // Fallback to contact_email if mail_username is not set
            if (!$recipientEmail) {
                $recipientEmail = Setting::where('key', 'contact_email')->value('value');
            }
            
            if ($recipientEmail) {
                // Send auto-reply to sender
                Mail::to($contact->email)->send(new \App\Mail\ContactAutoReply($contact));
                
                // Send notification to admin (mail_username)
                Mail::to($recipientEmail)->send(new \App\Mail\ContactNotification($contact));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send contact form email: ' . $e->getMessage());
        }

        return back()->with('success', 'Terima kasih telah menghubungi kami! Kami akan segera merespons pesan Anda.');
    }
}
