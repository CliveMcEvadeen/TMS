@extends('layouts.app')

@section('content')
    <div class="text-right mb-2">
        @if (auth()->user()->hasRole('rental-admin'))
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-tooltip="tooltip"
                data-target="#create" data-placement="bottom" title="" data-original-title="Create User">
                <i class="ti-plus"></i>
            </button>
        @endif


    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $title }}</h4>
            <p class="card-description">
                Add, edit, reset and remove users.
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contacts</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $row)
                            @php
                                $user = auth()->user();
                            @endphp
                            <tr>
                                <td>
                                    <img style="border-radius: 100%"
                                        src="{{ $row->avatar ? asset('storage/' . $row->avatar) : asset('images/logo.png') }}"
                                        alt="user" width="40" height="40">
                                    {{ ucwords($row->name) }}
                                </td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->contact_no }}</td>
                                <td><span class="badge badge-primary"> {{ $row->roles[0]->name ?? '' }}</span></td>
                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                <td>
                                    <div class="row pl-3 ">
                                        <div class="col-auto p-0 mr-3">
                                            <form class="p-0 m-0" action="{{ route('users.reset', $row->id) }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to reset this user password?');">
                                                @csrf
                                                <button type="submit" class="btn btn-link btn-fw btn-sm p-0"
                                                    title="Reset Password">
                                                    <i class="ti-unlock"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-auto p-0 mr-3">
                                            <button type="button" onclick="getUser({{ $row->id }})"
                                                class="btn btn-link btn-fw btn-sm text-success p-0" data-toggle="modal"
                                                data-target="#update" title="Edit User">
                                                <i class="ti-pencil"></i>
                                            </button>
                                        </div>
                                        @can('delete')
                                            @if ($user->id != $row->id)
                                                <div class="col-auto p-0">
                                                    <form class="p-0 m-0" action="{{ route('users.delete', $row->id) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Do you wish to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link btn-fw btn-sm text-danger p-0"><i
                                                                class="ti-trash" title="Delete User"></i></button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No record found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $users->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @include('users.modal')
@endsection

@push('footer-script')
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function getUser(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {

                    console.log(response.roles)

                    $('#name').val(response.user.name);
                    $('#contact_no').val(response.user.contact_no);
                    $('#email').val(response.user.email);
                    $('#user_id').val(response.user.id);
                    $('#role_id').val(response.role_id);

                },
                error: function(xhr) {
                    // Handle the error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
