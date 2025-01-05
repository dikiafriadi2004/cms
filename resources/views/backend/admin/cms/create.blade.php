@extends('backend.layouts.app')

@section('title')
    Pages List
@endsection

@push('css')

@endpush

@section('content')
    <div class="content">
        <h2 class="intro-y text-lg font-medium mt-10">
           Create Pages
        </h2>
        <form action="{{ isset($cmsPage) ? route('admin.cms.update', ['id' => $cmsPage->id]) : route('admin.cms.store') }}" method="POST">
            @csrf
            @if(isset($cmsPage))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $cmsPage->title ?? old('title') }}" required>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ $cmsPage->slug ?? old('slug') }}" required>
            </div>
            <div class="mb-3">
                <label for="menu" class="form-label">Menu</label>
                <input type="text" class="form-control" id="menu" name="menu" value="{{ $cmsPage->menu ?? old('menu') }}" required>
            </div>
            <div class="mb-3">
                <label for="order_by" class="form-label">Order By</label>
                <input type="number" class="form-control" id="order_by" name="order_by" value="{{ $cmsPage->order_by ?? old('order_by') }}" required>
            </div>
            <div class="mb-3">
                <label for="active" class="form-label">Active</label>
                <select class="form-control" id="active" name="active" required>
                    <option value="1" {{ isset($cmsPage) && $cmsPage->active ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ isset($cmsPage) && !$cmsPage->active ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="html_code" class="form-label">HTML Code</label>
                <textarea class="form-control code-editor" id="html_code" name="html_code" rows="5">{{ $cmsPage->html_code ?? old('html_code') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="style_code" class="form-label">CSS Code</label>
                <textarea class="form-control code-editor" id="style_code" name="style_code" rows="5" >{{ $cmsPage->style_code ?? old('style_code') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="js_code" class="form-label">JavaScript Code</label>
                <textarea class="form-control code-editor" id="js_code" name="js_code" rows="5" >{{ $cmsPage->js_code ?? old('js_code') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">{{ isset($cmsPage) ? 'Update' : 'Create' }}</button>
        </form>
    </div>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const textareas = document.querySelectorAll(".code-editor");
    const editors = [];

    textareas.forEach((textarea) => {
        const editor = CodeMirror.fromTextArea(textarea, {
            lineNumbers: true,
            mode: textarea.id === "html_code" ? "xml" : textarea.id === "style_code" ? "css" : "javascript",
            theme: "default",
        });

        // Sinkronkan editor dengan textarea saat form dikirimkan
        editor.on("change", () => {
            textarea.value = editor.getValue();
        });

        editors.push(editor);
    });

    // Sinkronkan nilai semua editor sebelum formulir dikirim
    const form = document.querySelector("form"); // Ganti dengan selektor formulir Anda
    if (form) {
        form.addEventListener("submit", function () {
            editors.forEach((editor) => {
                const textarea = editor.getTextArea();
                textarea.value = editor.getValue();
            });
        });
    }
});
    </script>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        const swal = $('.swal-notif').data('swal');
        if (swal) {
            Swal.fire({
                'title': 'Success',
                'text': swal,
                'icon': 'success',
                'showConfirmButton': false,
                'timer': 2000
            })
        }
    </script>
@endpush
