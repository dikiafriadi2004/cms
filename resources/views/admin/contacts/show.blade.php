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
                    
                    <!-- Template Selector -->
                    <div class="mb-3 flex gap-2">
                        <select id="template-selector" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Template --</option>
                            <option value="terima_kasih">Terima Kasih</option>
                            <option value="informasi_produk">Informasi Produk</option>
                            <option value="konfirmasi_pesanan">Konfirmasi Pesanan</option>
                            <option value="follow_up">Follow Up</option>
                            <option value="penolakan_sopan">Penolakan Sopan</option>
                        </select>
                        <button type="button" onclick="showTemplateModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview & Insert
                        </button>
                    </div>
                    
                    <div id="reply-editor" class="bg-white border border-gray-300 rounded-lg" style="min-height: 300px;"></div>
                    <textarea name="message" id="message" style="display:none;">{{ old('message') }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">💡 Tip: Pilih template di atas untuk mempercepat balasan Anda</p>
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

<!-- Template Preview Modal -->
<div id="template-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-bold text-gray-900">Preview Template</h3>
                <button type="button" onclick="closeTemplateModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body - Scrollable -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 overflow-y-auto flex-1 min-h-0">
            <div class="mb-3 sm:mb-4 p-2.5 sm:p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-xs text-blue-800">
                        <p class="font-semibold mb-0.5">Template ini adalah starting point</p>
                        <p class="hidden sm:block text-xs">Setelah di-insert, Anda bisa mengedit sesuai kebutuhan. Bagian yang ditandai dengan <strong>[HURUF KAPITAL]</strong> perlu disesuaikan.</p>
                        <p class="sm:hidden text-xs">Edit bagian <strong>[HURUF KAPITAL]</strong> setelah insert.</p>
                    </div>
                </div>
            </div>

            <div id="template-preview" class="prose prose-sm max-w-none bg-gray-50 p-3 sm:p-4 rounded-lg border border-gray-200 text-xs sm:text-sm">
                <!-- Template content will be inserted here -->
            </div>
        </div>

        <!-- Modal Footer - Fixed at bottom -->
        <div class="px-4 sm:px-6 py-2.5 sm:py-3 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-end gap-2 flex-shrink-0">
            <button type="button" onclick="closeTemplateModal()" class="w-full sm:w-auto px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium order-2 sm:order-1">
                Batal
            </button>
            <button type="button" onclick="insertTemplateFromModal()" class="w-full sm:w-auto px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-sm order-1 sm:order-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Insert Template
            </button>
        </div>
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

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Modal styles */
#template-modal {
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

#template-modal > div {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Preview content styling */
#template-preview {
    line-height: 1.6;
}

#template-preview p {
    margin-bottom: 1em;
}

#template-preview ul {
    margin-left: 1.5em;
    margin-bottom: 1em;
}

#template-preview li {
    margin-bottom: 0.5em;
}

#template-preview strong {
    font-weight: 600;
    color: #1f2937;
}

#template-preview em {
    font-style: italic;
    color: #4b5563;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Email templates
const templates = {
    terima_kasih: `<p>Halo <strong>{{ $contact->name }}</strong>,</p>
<p><br></p>
<p>Terima kasih telah menghubungi kami. Kami sangat menghargai waktu Anda untuk mengirimkan pesan kepada kami.</p>
<p><br></p>
<p>[TAMBAHKAN PESAN ANDA DI SINI]</p>
<p><br></p>
<p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali.</p>
<p><br></p>
<p>Salam hangat,<br>
<strong>Tim {{ config('app.name') }}</strong></p>`,

    informasi_produk: `<p>Halo <strong>{{ $contact->name }}</strong>,</p>
<p><br></p>
<p>Terima kasih atas ketertarikan Anda terhadap produk/layanan kami.</p>
<p><br></p>
<p>[JELASKAN INFORMASI PRODUK DI SINI]</p>
<p><br></p>
<p><strong>Fitur Utama:</strong></p>
<ul>
    <li>Fitur 1</li>
    <li>Fitur 2</li>
    <li>Fitur 3</li>
</ul>
<p><br></p>
<p><strong>Harga:</strong> [MASUKKAN HARGA]</p>
<p><br></p>
<p>Untuk informasi lebih detail atau pemesanan, silakan hubungi kami di:</p>
<p>📞 [NOMOR TELEPON]<br>
📧 [EMAIL]<br>
💬 [WHATSAPP]</p>
<p><br></p>
<p>Salam,<br>
<strong>Tim {{ config('app.name') }}</strong></p>`,

    konfirmasi_pesanan: `<p>Halo <strong>{{ $contact->name }}</strong>,</p>
<p><br></p>
<p>Terima kasih atas pesanan Anda!</p>
<p><br></p>
<p><strong>Detail Pesanan:</strong></p>
<ul>
    <li>Nomor Pesanan: [NOMOR PESANAN]</li>
    <li>Tanggal: [TANGGAL]</li>
    <li>Total: [TOTAL]</li>
</ul>
<p><br></p>
<p>[TAMBAHKAN INFORMASI TAMBAHAN]</p>
<p><br></p>
<p>Pesanan Anda sedang diproses dan akan segera kami kirimkan. Anda akan menerima notifikasi pengiriman melalui email.</p>
<p><br></p>
<p>Terima kasih atas kepercayaan Anda!</p>
<p><br></p>
<p>Hormat kami,<br>
<strong>Tim {{ config('app.name') }}</strong></p>`,

    follow_up: `<p>Halo <strong>{{ $contact->name }}</strong>,</p>
<p><br></p>
<p>Kami ingin menindaklanjuti pesan Anda sebelumnya mengenai: <em>"{{ $contact->subject }}"</em></p>
<p><br></p>
<p>[TAMBAHKAN FOLLOW UP ANDA DI SINI]</p>
<p><br></p>
<p>Apakah ada yang bisa kami bantu lebih lanjut?</p>
<p><br></p>
<p>Kami menunggu kabar dari Anda.</p>
<p><br></p>
<p>Salam,<br>
<strong>Tim {{ config('app.name') }}</strong></p>`,

    penolakan_sopan: `<p>Halo <strong>{{ $contact->name }}</strong>,</p>
<p><br></p>
<p>Terima kasih atas pesan Anda. Kami sangat menghargai ketertarikan Anda.</p>
<p><br></p>
<p>Namun, saat ini kami [JELASKAN ALASAN PENOLAKAN DENGAN SOPAN].</p>
<p><br></p>
<p>[TAMBAHKAN ALTERNATIF ATAU SARAN JIKA ADA]</p>
<p><br></p>
<p>Kami mohon maaf atas ketidaknyamanan ini dan berharap dapat bekerja sama dengan Anda di kesempatan lain.</p>
<p><br></p>
<p>Terima kasih atas pengertiannya.</p>
<p><br></p>
<p>Salam hormat,<br>
<strong>Tim {{ config('app.name') }}</strong></p>`
};

// Template names for display
const templateNames = {
    terima_kasih: 'Terima Kasih',
    informasi_produk: 'Informasi Produk',
    konfirmasi_pesanan: 'Konfirmasi Pesanan',
    follow_up: 'Follow Up',
    penolakan_sopan: 'Penolakan Sopan'
};

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

// Show template modal
function showTemplateModal() {
    const selector = document.getElementById('template-selector');
    const templateKey = selector.value;
    
    if (!templateKey) {
        alert('Silakan pilih template terlebih dahulu');
        return;
    }
    
    const templateHtml = templates[templateKey];
    const modal = document.getElementById('template-modal');
    const preview = document.getElementById('template-preview');
    
    // Set preview content
    preview.innerHTML = templateHtml;
    
    // Show modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close template modal
function closeTemplateModal() {
    const modal = document.getElementById('template-modal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Insert template from modal
function insertTemplateFromModal() {
    const selector = document.getElementById('template-selector');
    const templateKey = selector.value;
    const templateHtml = templates[templateKey];
    
    // Insert to editor
    quill.root.innerHTML = templateHtml;
    
    // Close modal
    closeTemplateModal();
    
    // Reset selector
    selector.value = '';
    
    // Focus on editor
    quill.focus();
    
    // Show success message
    showNotification('✅ Template berhasil di-insert! Silakan edit sesuai kebutuhan.');
}

// Close modal when clicking outside
document.getElementById('template-modal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeTemplateModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTemplateModal();
    }
});

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
    notification.innerHTML = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-10px)';
        notification.style.transition = 'all 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

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
