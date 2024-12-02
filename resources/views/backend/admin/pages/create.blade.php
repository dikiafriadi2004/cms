@extends('backend.layouts.app')

@section('title')
    Create Page
@endsection

@push('css')
    
@endpush

@section('content')
    <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Add New Page
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

                <button type="submit" class="btn btn-primary mr-2 flex items-center ml-auto sm:ml-0"> <i class="w-4 h-4 mr-2"
                        data-lucide="check"></i> Save </button>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-9">
                <input type="text" class="intro-y form-control py-3 px-4 box pr-10  @error('title') is-invalid @enderror"
                    name="title" placeholder="Title" value="{{ old('title') }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="post intro-y overflow-hidden box mt-5">
                    <div class="post__content tab-content">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mt-5">
                                <div
                                    class="font-medium flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Content
                                </div>
                                <div class="mt-5 @error('content') is-invalid @enderror">
                                    <textarea class="w-full ckeditor" id="content" name="content" rows="3">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-3">
                <div class="intro-y box p-5">
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">Status</label>
                        <select class="form-select sm:mr-2" name="status" aria-label="Default select example">
                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Published" {{ old('status') == 'Publish' ? 'selected' : '' }}>Publish</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- END: Post Info -->
        </div>
    </form>
@endsection

@push('js')
    <script src="{{ asset('backend/assets/js/ckeditor/ckeditor.js') }}"></script>
@endpush