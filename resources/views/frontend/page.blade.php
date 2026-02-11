@extends('frontend.layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $page->meta_description ?? strip_tags(substr($page->content, 0, 160)))

@push('styles')
<style>
.policy-content h2 { 
    font-size: 1.5rem; 
    font-weight: 800; 
    color: #1e1b4b; 
    margin-top: 2.5rem; 
    margin-bottom: 1rem;
}
.policy-content h3 { 
    font-size: 1.25rem; 
    font-weight: 700; 
    color: #1e1b4b; 
    margin-top: 2rem; 
    margin-bottom: 0.75rem;
}
.policy-content h4 { 
    font-size: 1.125rem; 
    font-weight: 600; 
    color: #1e1b4b; 
    margin-top: 1.5rem; 
    margin-bottom: 0.5rem;
}
.policy-content p { 
    color: #475569; 
    line-height: 1.8; 
    margin-bottom: 1.25rem;
}
.policy-content ul { 
    list-style-type: disc; 
    margin-left: 1.5rem; 
    margin-bottom: 1.5rem; 
    color: #475569;
}
.policy-content ol { 
    list-style-type: decimal; 
    margin-left: 1.5rem; 
    margin-bottom: 1.5rem; 
    color: #475569;
}
.policy-content li { 
    margin-bottom: 0.5rem; 
}
.policy-content a {
    color: #4f46e5;
    text-decoration: underline;
    font-weight: 600;
}
.policy-content a:hover {
    color: #4338ca;
}
.policy-content strong {
    font-weight: 700;
    color: #1e1b4b;
}
.policy-content blockquote {
    border-left: 4px solid #4f46e5;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #64748b;
}
.policy-content img {
    border-radius: 1rem;
    margin: 2rem 0;
    max-width: 100%;
    height: auto;
}
.policy-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
}
.policy-content table th {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    text-align: left;
    font-weight: 700;
    color: #1e1b4b;
    border: 1px solid #e2e8f0;
}
.policy-content table td {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    color: #475569;
}
</style>
@endpush

@section('content')
<main class="pt-40 pb-24 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-brand-900 mb-4">
                {{ $page->title }}
            </h1>
            
            @if($page->published_at)
            <p class="text-slate-400 font-medium">
                Terakhir diperbarui: {{ $page->published_at->format('d F Y') }}
            </p>
            @endif
            
            <div class="w-20 h-1.5 bg-brand-600 mx-auto mt-6 rounded-full"></div>
        </div>

        <!-- Ad: Content Top -->
        @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
            @foreach($ads['content_top'] as $ad)
                <div class="mb-8 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50/50">
                    {!! $ad->render() !!}
                </div>
            @endforeach
        @endif

        <!-- Page Content -->
        <div class="policy-content bg-slate-50/50 p-8 md:p-12 rounded-[3rem] border border-slate-100">
            @if($page->excerpt)
            <p class="text-lg font-medium text-slate-700 mb-8">
                {{ $page->excerpt }}
            </p>
            @endif

            @if($page->featured_image)
            <div class="mb-8 -mx-8 md:-mx-12">
                <img src="{{ $page->featured_image }}" 
                     alt="{{ $page->title }}" 
                     class="w-full h-auto object-cover rounded-t-[3rem]">
            </div>
            @endif

            <div class="prose-content">
                {!! $page->content !!}
            </div>

            <!-- Contact Box -->
            @if(isset($settings['contact_email']) && $settings['contact_email'])
            <div class="mt-12 p-6 bg-brand-50 rounded-2xl border border-brand-100">
                <p class="text-sm font-bold text-brand-900 mb-2">Punya pertanyaan lebih lanjut?</p>
                <p class="text-sm text-slate-600 mb-0">
                    Silahkan hubungi tim kami melalui email di 
                    <a href="mailto:{{ $settings['contact_email'] }}" 
                       class="text-brand-600 font-bold underline">
                        {{ $settings['contact_email'] }}
                    </a>
                    @if(isset($settings['whatsapp_number']) && $settings['whatsapp_number'])
                    atau WhatsApp di 
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" 
                       target="_blank"
                       class="text-brand-600 font-bold underline">
                        {{ $settings['whatsapp_number'] }}
                    </a>
                    @endif
                </p>
            </div>
            @endif
        </div>

        <!-- Ad: Content Bottom -->
        @if(isset($ads['content_bottom']) && $ads['content_bottom']->count() > 0)
            @foreach($ads['content_bottom'] as $ad)
                <div class="mt-8 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50/50">
                    {!! $ad->render() !!}
                </div>
            @endforeach
        @endif

        <!-- Back to Home -->
        <div class="text-center mt-12">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-brand-600 hover:text-brand-700 font-bold transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>
@endsection
