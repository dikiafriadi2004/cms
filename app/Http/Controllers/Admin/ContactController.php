<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
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
            // Send email
            \Mail::send('emails.contact-reply', [
                'contact' => $contact,
                'replyMessage' => $validated['message']
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
