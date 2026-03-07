<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('pages.create');
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'template' => 'required|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul halaman wajib diisi.',
            'title.max' => 'Judul halaman maksimal 255 karakter.',
            'content.required' => 'Konten halaman wajib diisi.',
            'template.required' => 'Template wajib dipilih.',
            'status.required' => 'Status halaman wajib dipilih.',
            'status.in' => 'Status halaman tidak valid.',
            'canonical_url.url' => 'Canonical URL harus berupa URL yang valid.',
            'sort_order.min' => 'Urutan tidak boleh negatif.',
        ];
    }
}
