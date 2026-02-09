@extends('layouts.admin')

@section('title', 'View Contact Message')
@section('page-title', 'Contact Message Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Messages
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">{{ $contact->subject }}</h2>
                @if($contact->status === 'new')
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">New</span>
                @elseif($contact->status === 'read')
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Read</span>
                @else
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Replied</span>
                @endif
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">From</p>
                    <p class="font-semibold text-gray-900">{{ $contact->name }}</p>
                    <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-700 text-sm">{{ $contact->email }}</a>
                    @if($contact->phone)
                    <p class="text-sm text-gray-600 mt-1">
                        <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-700">{{ $contact->phone }}</a>
                    </p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Received</p>
                    <p class="font-semibold text-gray-900">{{ $contact->created_at->format('F d, Y') }}</p>
                    <p class="text-sm text-gray-600">{{ $contact->created_at->format('h:i A') }}</p>
                    <p class="text-xs text-gray-500 mt-1">IP: {{ $contact->ip_address }}</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Message</h3>
            <div class="prose max-w-none">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>
        </div>

        @if($contact->notes)
        <div class="px-6 py-4 bg-yellow-50 border-t border-yellow-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Admin Notes</h3>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->notes }}</p>
        </div>
        @endif

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Add internal notes about this message...">{{ $contact->notes }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Status
                    </button>
                    <button type="button" onclick="deleteContact()" class="inline-flex items-center px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($contact->read_at || $contact->replied_at)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Message Received</p>
                    <p class="text-sm text-gray-500">{{ $contact->created_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>
            @if($contact->read_at)
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Message Read</p>
                    <p class="text-sm text-gray-500">{{ $contact->read_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>
            @endif
            @if($contact->replied_at)
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Reply Sent</p>
                    <p class="text-sm text-gray-500">{{ $contact->replied_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <h3 class="text-lg font-semibold text-gray-900">Send Reply</h3>
        </div>
        <form method="POST" action="{{ route('admin.contacts.send-reply', $contact) }}" id="reply-form">
            @csrf
            <div class="p-6 space-y-6">
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" id="subject" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="{{ old('subject', 'Re: ' . $contact->subject) }}" placeholder="Enter email subject...">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message <span class="text-red-500">*</span></label>
                    <div id="reply-editor" class="bg-white border border-gray-300 rounded-lg" style="min-height: 300px;"></div>
                    <textarea name="message" id="message" style="display:none;">{{ old('message') }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Send Reply
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<form id="delete-form" method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.ql-container { min-height: 300px; font-size: 16px; }
.ql-editor { min-height: 300px; }
.ql-editor img { max-width: 100%; height: auto; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var quill = new Quill('#reply-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link'],
            ['clean']
        ]
    }
});

var form = document.getElementById('reply-form');
form.addEventListener('submit', function(e) {
    var html = quill.root.innerHTML;
    var text = quill.getText().trim();
    document.getElementById('message').value = html;
    if (!text) {
        e.preventDefault();
        alert('Pesan tidak boleh kosong!');
        return false;
    }
});

function deleteContact() {
    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
