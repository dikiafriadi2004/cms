@extends('layouts.app')

@section('title')
    Categories
@endsection

@push('css')
@endpush

@section('content')
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Categories
            </h2>
        </div>
        <div class="swal-notif" data-swal="{!! Session::get('success') !!}"></div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-4">
                <!-- BEGIN: Input -->
                @include('admin.category.create')
                <!-- END: Input -->
                <!-- END: Select Options -->
            </div>
            <div class="intro-y col-span-12 lg:col-span-8">
                <!-- BEGIN: Vertical Form -->
                <div class="intro-y box">
                    <div
                        class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Categories
                        </h2>
                    </div>
                    <div id="vertical-form" class="p-5">
                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">#</th>
                                        <th class="whitespace-nowrap">Name</th>
                                        <th class="text-center whitespace-nowrap">Slug</th>
                                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr class="intro-x">
                                            <td>
                                                <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">
                                                    {{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">
                                                    {{ $category->name }}
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $category->slug }}</td>
                                            <td class="table-report__action w-56">
                                                <div class="flex justify-center items-center">
                                                    <button class="flex items-center mr-3 edit" data-tw-toggle="modal"
                                                        data-tw-target="#modalCategory{{ $category->id }}"
                                                        data-tw-id="{{ $category->id }}"> <i data-lucide="check-square"
                                                            class="w-4 h-4 mr-1"></i> Edit </button>
                                                    {{-- <form
                                                        action="{{ route('category.destroy', ['category' => $category->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex items-center text-danger"> <i
                                                                data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                        </button>
                                                    </form> --}}
                                                    <button class="flex items-center  text-danger" data-tw-toggle="modal"
                                                        data-tw-target="#modalDeleteCategory{{ $category->id }}"
                                                        data-tw-id="{{ $category->id }}"> <i data-lucide="trash-2"
                                                            class="w-4 h-4 mr-1"></i> Delete
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                            {{ $categories->links() }}
                        </div>
                        <!-- END: Pagination -->
                    </div>
                </div>
                <!-- END: Vertical Form -->
            </div>
        </div>
        {{-- Modal Edit --}}
        @include('admin.category.modal-edit')

        {{-- Modal Delete --}}
        @include('admin.category.modal-delete')
    </div>
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
