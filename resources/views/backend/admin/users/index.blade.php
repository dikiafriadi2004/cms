@extends('backend.layouts.app')

@section('title')
    Users List
@endsection

@push('css')
    
@endpush

@section('content')
    <div class="content">
        <h2 class="intro-y text-lg font-medium mt-10">
            All Users List
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="swal-notif" data-swal="{!! Session::get('success') !!}"></div>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('users.create') }}" class="btn btn-primary shadow-md mr-2">Add New User</a>
                <div class="hidden md:block mx-auto text-slate-500"></div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form action="{{ route('users.index') }}" method="GET">
                            <input type="text" id="search" name="search" class="form-control w-56 box pr-10" placeholder="Search..." value="{{ request('search') }}">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">#</th>
                            <th class="whitespace-nowrap">NAME</th>
                            <th class="whitespace-nowrap">EMAIL</th>
                            <th class="text-center whitespace-nowrap">REGISTER DATE</th>
                            <th class="text-center whitespace-nowrap">VERIFY EMAIL</th>
                            <th class="text-center whitespace-nowrap">BLOCK</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="intro-x">
                                <td>
                                    <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">{{ $loop->iteration }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">{{ $user->name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-slate-500 font-medium whitespace-nowrap mt-0.5">{{ $user->email }}
                                    </div>
                                </td>
                                <td class="text-center">{{ $user->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                                <td class="text-center">{{ $user->email_verified_at != null ? 'Verified' : 'Not Verify' }}</td>
                                <td class="text-center">
                                    <a href="">No</a>
                                </td>
                                
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3"
                                            href="{{ route('users.edit', ['user' => $user->id]) }}"> <i
                                                data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <button class="flex items-center  text-danger" data-tw-toggle="modal"
                                            data-tw-target="#modalDeleteUser{{ $user->id }}"
                                            data-tw-id="{{ $user->id }}"> <i data-lucide="trash-2"
                                                class="w-4 h-4 mr-1"></i> Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {{ $users->links() }}
            </div>
            <!-- END: Pagination -->
        </div>
        <!-- BEGIN: Delete Confirmation Modal -->
        <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Are you sure?</div>
                            <div class="text-slate-500 mt-2">
                                Do you really want to delete these records?
                                <br>
                                This process cannot be undone.
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                            <button type="button" class="btn btn-danger w-24">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
        @include('backend.admin.users.modal-delete')
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