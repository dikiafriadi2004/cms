<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\SettingsCache;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query()->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        // Single query untuk semua stats
        $allStats = Contact::selectRaw("
            COUNT(*) as total,
            SUM(status = 'new') as new,
            SUM(status = 'read') as `read`,
            SUM(status = 'replied') as replied
        ")->first();

        $stats = [
            'total' => $allStats->total,
            'new' => $allStats->new,
            'read' => $allStats->read,
            'replied' => $allStats->replied,
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    public function show(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->status === 'new') {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied',
            'notes' => 'nullable|string|max:1000',
        ]);

        $contact->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $contact->notes,
        ]);

        if ($validated['status'] === 'read' && !$contact->read_at) {
            $contact->markAsRead();
        } elseif ($validated['status'] === 'replied') {
            $contact->markAsReplied();
        }

        return back()->with('success', 'Status kontak berhasil diupdate!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        // Check if request expects JSON (AJAX)
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kontak berhasil dihapus!'
            ]);
        }
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Kontak berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        $count = Contact::whereIn('id', $validated['ids'])->delete();
        
        // Check if request expects JSON (AJAX)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $count . ' kontak berhasil dihapus!'
            ]);
        }

        return back()->with('success', $count . ' kontak berhasil dihapus!');
    }

    public function sendReply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Ambil semua settings sekaligus dari cache
            $settings = SettingsCache::all();
            $siteName = $settings['site_name'] ?? config('app.name');
            $logo = $settings['logo'] ?? null;
            $contactEmail = $settings['contact_email'] ?? null;
            $contactPhone = $settings['contact_phone'] ?? null;
            $contactAddress = $settings['contact_address'] ?? null;
            $socialFacebook = $settings['social_facebook'] ?? null;
            $socialInstagram = $settings['social_instagram'] ?? null;
            $socialTwitter = $settings['social_twitter'] ?? null;

            // Check if using real domain (not ngrok or localhost)
            $isRealDomain = !str_contains(config('app.url'), 'ngrok') && 
                            !str_contains(config('app.url'), 'localhost') &&
                            !str_contains(config('app.url'), '127.0.0.1');

            // Send email
            \Mail::send('emails.contact-reply', [
                'contact' => $contact,
                'replyMessage' => $validated['message'],
                'siteName' => $siteName,
                'logo' => $logo,
                'hasLogo' => $isRealDomain && !empty($logo),
                'contactEmail' => $contactEmail,
                'contactPhone' => $contactPhone,
                'contactAddress' => $contactAddress,
                'socialFacebook' => $socialFacebook,
                'socialInstagram' => $socialInstagram,
                'socialTwitter' => $socialTwitter,
            ], function ($message) use ($contact, $validated) {
                $message->to($contact->email, $contact->name)
                        ->subject($validated['subject']);
            });

            // Mark as replied
            $contact->markAsReplied();

            return redirect()->route('admin.contacts.show', $contact)
                ->with('success', 'Balasan berhasil dikirim ke ' . $contact->email);

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
