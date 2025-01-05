@extends('backend.layouts.app')

@section('title')
    Menu List
@endsection

@push('css')

@endpush

@section('content')
    <div class="content">
        <h2 class="intro-y text-lg font-medium mt-10">
            All Menu List
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="swal-notif" data-swal="{!! Session::get('success') !!}"></div>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
               <div class="hidden md:block mx-auto text-slate-500"></div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form action="{{ route('admin.menu.index') }}" method="GET">
                            <input type="text" id="search" name="search" class="form-control w-56 box pr-10" placeholder="Search..." value="{{ request('search') }}">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Order By</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortablemenu">
                        @foreach ($cmsMenu as $page)
                        <tr data-id="{{ $page->id }}">
                            <td>{{ $page->menu }}</td>
                            <td>{{ $page->order_by }}</td>
                            <td>{{ $page->active ? 'Yes' : 'No' }}</td>
                            <td>
                                <form class="mb-3" action="{{ route('admin.menu.updateOrder', $page->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="up" class="btn btn-info btn-sm">Up</button>
                                    <button type="submit" name="action" value="down" class="btn btn-info btn-sm">Down</button>
                                </form>
                                <form action="{{ route('admin.menu.toggleActive', $page->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ $page->active ? 'danger' : 'success' }} btn-sm">
                                        {{ $page->active ? 'Inactive' : 'Active' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {{ $cmsMenu->links() }}
            </div>
            <!-- END: Pagination -->
        </div>
        <!-- BEGIN: Delete Confirmation Modal -->

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
