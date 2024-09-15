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
            <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="tableToPDF('propertyTable')"
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
                        Add, edit, and remove properties.
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
                <table class="table table-striped table-borderless" id="propertyTable">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Location</th>
                            <th>Owner</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="hide-column">Image</th>

                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($properties as $row)
                            <tr>
                                <td><a href="{{ route('property.view', $row->id) }}">{{ ucwords($row->property_name) }}</a>
                                </td>
                                <td>{{ $row->location }}</td>
                                <td><a href="{{ route('owners.view', $row->owner->id) }}">{{ $row->owner->name }}</a></td>

                                <td>{{ number_format($row->price, 2) }}</td>
                                <td>
                                    @php
                                        $badge = $row->status == 'vacant' ? 'primary' : ($row->status == 'sold' ? 'success' : 'info');
                                    @endphp
                                    <span class="badge badge-{{ $badge }}"> {{ $row->status }}</span>
                                </td>
                                <td> <img class="img-fluid"
                                        src="{{ $row->image ? asset('storage/' . $row->image) : asset('images/logo.png') }}"
                                        alt="user" width="40" height="40">
                                </td>

                                <td>
                                    <div class="row pl-3">
                                        <div class="col-auto p-0 mr-2">
                                            <button type="button" onclick="getProperty({{ $row->id }})"
                                                class="btn btn-link btn-fw btn-sm text-success p-0" data-toggle="modal"
                                                data-target="#edit" title="Edit Property">
                                                <i class="ti-pencil"></i>
                                            </button>
                                        </div>
                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('property.view', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-info p-0" title="View Property">
                                                <i class="ti-home"></i>
                                            </a>
                                        </div>
                                        @can('delete')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="{{ route('property.destroy', $row->id) }}"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this property?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-fw btn-sm text-danger p-0"><i
                                                            class="ti-trash" title="Delete Property"></i></button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No record found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $properties->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @include('property.modal')
@endsection

@push('footer-script')
    <script>
        function getProperty(id) {
            $.get({
                url: window.location.href + "/" + id,
                success: function(response) {

                    console.log(response)

                    $('#property_id').val(response.id);
                    $('#owner_id').val(response.owner_id);;
                    $('#property_name').val(response.property_name);
                    $('#location').val(response.location);
                    $('#price').val(response.price);
                    $('#monthly').val(response.monthly);
                    $('#yearly').val(response.yearly);
                    $('#status').val(response.status);
                },
                error: function(xhr) {
                    // Handle the error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
