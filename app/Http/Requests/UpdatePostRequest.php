<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        $post = $this->route('post');
        
        // Author can only edit their own posts
        if ($this->user()->hasRole('author')) {
            return $post->user_id === $this->user()->id;
        }
        
        return $this->user()->can('posts.edit');
    }

    public function rules(): array
    {
        $postId = $this->route('post')->id;
        
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug,' . $postId,
            'excerpt' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'focus_keyword' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul post wajib diisi.',
            'title.max' => 'Judul post maksimal 255 karakter.',
            'content.required' => 'Konten post wajib diisi.',
            'status.required' => 'Status post wajib dipilih.',
            'status.in' => 'Status post tidak valid.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tags.array' => 'Format tags tidak valid.',
            'canonical_url.url' => 'Canonical URL harus berupa URL yang valid.',
        ];
    }
}
