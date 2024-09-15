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
            <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="tableToPDF('tenantTable')"
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
                        Add, edit, and remove tenants.
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
                <table class="table table-striped table-borderless" id="tenantTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tenants as $row)
                            <tr>
                                <td><img class="img-fluid"
                                        src="{{ $row->image ? asset('storage/' . $row->image) : asset('images/logo.png') }}"
                                        alt="user" width="40" height="40">
                                    <a href="{{ route('tenants.view', $row->id) }}">{{ ucwords($row->name) }} </a>
                                </td>
                                <td>{{ $row->contact_no }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->address }}</td>
                                <td>
                                    <div class="row pl-3">
                                        <div class="col-auto p-0 mr-2">
                                            <button type="button" onclick="getTenant({{ $row->id }})"
                                                class="btn btn-link btn-fw btn-sm text-success p-0" data-toggle="modal"
                                                data-target="#edit" title="Edit Tenant">
                                                <i class="ti-pencil"></i>
                                            </button>
                                        </div>
                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('tenants.view', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-info p-0" title="View Tenant">
                                                <i class="ti-user"></i>
                                            </a>
                                        </div>
                                        @can('delete')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="{{ route('tenants.destroy', $row->id) }}"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this tenant?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-fw btn-sm text-danger p-0"><i
                                                            class="ti-trash" title="Delete Tenant"></i></button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No
                                    record
                                    found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $tenants->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @include('tenants.modal')
@endsection

@push('footer-script')
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function getTenant(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {

                    console.log(response)

                    $('#tenant_id').val(response.id);
                    $('#name').val(response.name);;
                    $('#contact_no').val(response.contact_no);
                    $('#email').val(response.email);
                    $('#address').val(response.address);
                },
                error: function(xhr) {
                    // Handle the error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
