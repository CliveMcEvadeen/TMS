@extends('layouts.app')

@section('content')
    <div class="text-right mb-2">
        @if (auth()->user()->hasRole('rental-admin'))
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-tooltip="tooltip"
                data-target="#filter_date" title="Filter Date">
                <i class="ti-filter"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-tooltip="tooltip" data-placement="bottom"
                title="" data-original-title="Create Rents" onclick="location.href='{{ route('rents.create') }}'">
                <i class="ti-plus"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal"
                onclick="location.href='{{ url()->current() }}'" title="Reload">
                <i class="ti-reload"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="tableToPDF('rentTable')"
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
                        Add, edit, and remove rents.
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
                <table class="table table-striped table-borderless" id="rentTable">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Tenant</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @forelse ($rents as $row)
                            <tr>
                                <td><a
                                        href="{{ route('property.view', $row->property->id) }}">{{ ucwords($row->property->property_name) }}</a>
                                </td>
                                <td><a href="{{ route('tenants.view', $row->tenant->id) }}">
                                        {{ ucwords($row->tenant->name) }}
                                    </a>
                                </td>
                                <td>{{ date('Y-m-d', strtotime($row->start_date)) }}</td>
                                <td>{{ date('Y-m-d', strtotime($row->end_date)) }}</td>
                                <td>
                                    <span class="badge badge-primary"> {{ ucwords($row->rent_type) }}</span>
                                </td>


                                <td>{{ $row->discount }} %</td>
                                <td>
                                    @php
                                        $badge = $row->status == 'new' ? 'success' : 'info';
                                    @endphp
                                    <span class="badge badge-{{ $badge }}"> {{ ucwords($row->status) }}</span>
                                </td>

                                <td>
                                    @php
                                        $amount = $row->discount > 0 ? $row->amount - $row->amount * ($row->discount / 100) : $row->amount;
                                    @endphp
                                    {{ number_format($amount, 2) }}
                                </td>
                                <td>
                                    <div class="row pl-3">
                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('rents.edit', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-success p-0" title="Edit Rent">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </div>
                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('rents.contract', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-primary p-0" title="Lease Agreement">
                                                <i class="ti-write"></i>
                                            </a>
                                        </div>
                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('rents.show', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-info p-0" title="View Rent">
                                                <i class="ti-layers-alt"></i>
                                            </a>
                                        </div>
                                        @can('delete')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="{{ route('rents.destroy', $row->id) }}"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this rent?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-fw btn-sm text-danger p-0"><i
                                                            class="ti-trash" title="Delete Rent"></i></button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @php
                                $total += $amount;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No record found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="7">Total:</th>
                            <th class="text-left">P {{ number_format($total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $rents->links() }}
                </ul>
            </nav>
        </div>
    </div>
    <div class="modal fade" id="filter_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-3">Filter By Start Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="from_date" id="from_date"
                                value="{{ isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="to_date" id="to_date"
                                value="{{ isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function getProperty(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {

                    console.log(response)

                    $('#property_id').val(response.id);
                    $('#owner_id').val(response.owner_id);;
                    $('#property_name').val(response.property_name);
                    $('#location').val(response.location);
                    $('#price').val(response.price);
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
