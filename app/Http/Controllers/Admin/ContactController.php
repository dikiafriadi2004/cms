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
            $search = safe_like_input($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $perPage = in_array($request->input('per_page'), [5, 10, 20, 50]) ? (int) $request->input('per_page') : 20;
        $contacts = $query->paginate($perPage)->withQueryString();

        // Single query untuk semua stats — pakai CASE WHEN supaya portable
        // (lebih aman dari `SUM(status = 'x')` yang bergantung pada vendor SQL mode).
        $allStats = Contact::selectRaw("
            COUNT(*) AS total,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) AS new_count,
            SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) AS read_count,
            SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) AS replied_count
        ")->first();

        $stats = [
            'total' => (int) $allStats->total,
            'new' => (int) $allStats->new_count,
            'read' => (int) $allStats->read_count,
            'replied' => (int) $allStats->replied_count,
        ];

        return view('admin.contacts.index', compact('contacts', 'stats', 'perPage'));
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
            'message' => 'required|string|max:10000',
        ]);

        try {
            // Ambil semua settings sekaligus dari cache
            $settings = SettingsCache::all();
            $appUrl = config('app.url');
            $isRealDomain = !str_contains($appUrl, 'ngrok')
                && !str_contains($appUrl, 'localhost')
                && !str_contains($appUrl, '127.0.0.1');

            $branding = [
                'siteName' => $settings['site_name'] ?? config('app.name'),
                'logo' => $settings['logo'] ?? null,
                'hasLogo' => $isRealDomain && !empty($settings['logo'] ?? null),
                'contactEmail' => $settings['contact_email'] ?? null,
                'contactPhone' => $settings['contact_phone'] ?? null,
                'contactAddress' => $settings['contact_address'] ?? null,
                'socialFacebook' => $settings['social_facebook'] ?? null,
                'socialInstagram' => $settings['social_instagram'] ?? null,
                'socialTwitter' => $settings['social_twitter'] ?? null,
            ];

            // Queue (truly async) the mail to avoid blocking the request.
            // ContactReplyMail::fromContact() unpacks the Contact into plain
            // properties, so the queue job will not fail if Contact is deleted
            // between dispatch and worker processing.
            \Mail::to($contact->email, $contact->name)
                ->queue(\App\Mail\ContactReplyMail::fromContact(
                    $contact,
                    $validated['message'],
                    $validated['subject'],
                    $branding
                ));

            // Mark as replied immediately. If the queued job fails later,
            // the failed_jobs table + Queue::failing handler will notify admin.
            $contact->markAsReplied();

            return redirect()->route('admin.contacts.show', $contact)
                ->with('success', 'Balasan sedang dikirim ke ' . $contact->email);

        } catch (\Exception $e) {
            \Log::error('Contact reply failed', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withInput()
                ->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
