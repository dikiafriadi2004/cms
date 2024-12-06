@extends('backend.layouts.app')

@section('title')
    Create User
@endsection

@push('css')
@endpush

@section('content')
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Vertical Form -->
            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Create User
                    </h2>
                </div>
                <div id="vertical-form" class="p-5">
                    <div class="preview">
                        <div>
                            <label for="vertical-form-1" class="form-label">Name</label>
                            <input id="vertical-form-1" type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="example@gmail.com"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="vertical-form-1" class="form-label">Email</label>
                            <input id="vertical-form-1" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mt-5">
                            <input id="vertical-form-3" class="form-check-input" type="checkbox" value="1"
                                name="email_verified_at" {{ old('email_verified_at') == null ? '' : 'checked' }}>
                            <label class="form-check-label" for="vertical-form-3">Verify Email</label>
                        </div>
                        <div class="mt-3">
                            <label for="vertical-form-2" class="form-label">Password</label>
                            <input id="vertical-form-2" type="password" name="password" class="form-control"
                                placeholder="secret">
                        </div>

                        <div class="mt-3">
                            <label for="vertical-form-2" class="form-label">Confirmation Password</label>
                            <input id="vertical-form-2" type="password" name="password_confirmation" class="form-control"
                                placeholder="secret">
                        </div>
                        <div class="mt-3">
                            <span>Role Permission</span>
                        </div>
                        @foreach ($permissions as $permission)
                            <div class="form-check mt-5">
                                <input id="permissions-{{ $permission->name }}" class="form-check-input" type="checkbox"
                                    value="{{ $permission->name }}"
                                    {{ old('permission') && in_array($permission->name, old('permission')) ? 'checked' : '' }}
                                    name="permissions[]">
                                <label class="form-check-label"
                                    for="permissions-{{ $permission->name }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-5">Save</button>
                    </div>
                </div>
            </div>
            <!-- END: Vertical Form -->
        </div>
    </form>
@endsection

@push('js')
@endpush
