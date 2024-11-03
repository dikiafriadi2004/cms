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
                                                <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">{{ $category->name }}
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $category->slug }}</td>
                                            <td class="table-report__action w-56">
                                                <div class="flex justify-center items-center">
                                                    <a class="flex items-center mr-3" href=""> <i
                                                            data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                    <a class="flex items-center text-danger" href=""> <i
                                                            data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                            <nav class="w-full sm:w-auto sm:mr-auto">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-lucide="chevrons-left"></i> </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-lucide="chevron-left"></i> </a>
                                    </li>
                                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                                    <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-lucide="chevron-right"></i> </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-lucide="chevrons-right"></i> </a>
                                    </li>
                                </ul>
                            </nav>
                            <select class="w-20 form-select box mt-3 sm:mt-0">
                                <option>10</option>
                                <option>25</option>
                                <option>35</option>
                                <option>50</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END: Vertical Form -->
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
