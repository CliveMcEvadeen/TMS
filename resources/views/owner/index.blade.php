@extends('layouts.app')

@section('content')
    <div class="text-right mb-2">
        @if (auth()->user()->hasRole('rental-admin'))
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-tooltip="tooltip"
                data-target="#create" data-placement="bottom" title="" data-original-title="Create Owner">
                <i class="ti-plus"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal"
                onclick="location.href='{{ url()->current() }}'" title="Reload">
                <i class="ti-reload"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="tableToPDF('ownerTable')"
                data-tooltip="tooltip" title="Download Table">
                <i class="ti-import"></i>
            </button>
        @endif


    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="card-title">{{ $title }}</h4>
                    <p class="card-description">
                        Add, edit, and remove owners.
                    </p>
                </div>
                <div class="col-md-4">
                    <form class="d-flex justify-content-between">
                        <label class="sr-only" for="inlineFormInputName2">Name</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" name="search" id="inlineFormInputName2"
                            placeholder="Please enter to search"
                            value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-borderless" id="ownerTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contacts</th>
                            <th>Created at</th>
                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($owners as $row)
                            <tr>
                                <td>
                                    <img style="border-radius: 100%"
                                        src="{{ $row->image ? asset('storage/' . $row->image) : asset('images/logo.png') }}"
                                        alt="user" width="40" height="40">
                                    <a href="{{ route('owners.view', $row->id) }}">{{ ucwords($row->name) }}</a>
                                </td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->contact_no }}</td>
                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                <td>
                                    <div class="row pl-3">
                                        <div class="col-auto p-0 mr-2">
                                            <button type="button" onclick="getOwner({{ $row->id }})"
                                                class="btn btn-link btn-fw btn-sm text-success p-0" data-toggle="modal"
                                                data-target="#edit" title="Edit Owner">
                                                <i class="ti-pencil"></i>
                                            </button>
                                        </div>
                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('owners.view', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-info p-0" title="View Owner">
                                                <i class="ti-user"></i>
                                            </a>
                                        </div>
                                        @can('delete')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="{{ route('owners.destroy', $row->id) }}"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this owner?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-fw btn-sm text-danger p-0"><i
                                                            class="ti-trash" title="Delete Owner"></i></button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No record found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $owners->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @include('owner.modal')
@endsection

@push('footer-script')
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function getOwner(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {

                    console.log(response)

                    $('#owner_id').val(response.id);
                    $('#name').val(response.name);;
                    $('#contact_no').val(response.contact_no);
                    $('#address').val(response.address);
                    $('#email').val(response.email);

                },
                error: function(xhr) {
                    // Handle the error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
