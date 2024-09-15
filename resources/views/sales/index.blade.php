@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Today’s Sales</p>
                    <p class="fs-30 mb-2">P {{ number_format($today_sales, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Monthly Sales</p>
                    <p class="fs-30 mb-2">P {{ number_format($monthly_sales, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Yearly Sales</p>
                    <p class="fs-30 mb-2">P {{ number_format($yearly_sales, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Total Sales</p>
                    <p class="fs-30 mb-2">P {{ number_format($total_sales, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mb-2">

        <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-tooltip="tooltip"
            data-target="#filter_date" title="Filter Date">
            <i class="ti-filter"></i>
        </button>
        <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal"
            onclick="location.href='{{ url()->current() }}'" title="Reload">
            <i class="ti-reload"></i>
        </button>
        <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="tableToPDF('salesTable')"
            data-tooltip="tooltip" title="Download Table">
            <i class="ti-import"></i>
        </button>
        <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-tooltip="tooltip"
            data-target="#create" title="Create Sales">
            <i class="ti-plus"></i>
        </button>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="card-title">{{ $title }}</h4>
                    <p class="card-description">
                        Add, edit, and remove sales.
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
                <table class="table table-striped table-borderless" id="salesTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Covered Month</th>
                            <th>Tenant</th>
                            <th>Property</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @forelse ($sales as $row)
                            <tr>
                                <td>{{ date('Y-m-d', strtotime($row->transaction_date)) }}</td>
                                <td>{{ date('F', strtotime($row->payment->due_date)) ?? '' }}</td>
                                <td><a
                                        href="{{ route('tenants.view', $row->tenant->id ?? $row->payment->rent->tenant->id) }}">
                                        {{ $row->tenant->name ?? $row->payment->rent->tenant->name }}
                                    </a>
                                </td>
                                <td>{{ $row->property->property_name ?? $row->payment->rent->property->property_name }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $row->status ? 'success' : 'warning' }}">
                                        {{ $row->status ? 'completed' : 'pending' }}</span>
                                </td>
                                <td>{{ number_format($row->amount, 2) }}</td>
                                <td>
                                    <div class="row pl-3">
                                        @php
                                            $null = $row->tenant->name ?? 'null';
                                        @endphp
                                        @if ($null != 'null')
                                            <div class="col-auto p-0 mr-2">
                                                <button type="button" onclick="getSales({{ $row->id }})"
                                                    class="btn btn-link btn-fw btn-sm text-success p-0" data-toggle="modal"
                                                    data-target="#edit" title="Edit Sales">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                            </div>
                                        @endif

                                        <div class="col-auto p-0 mr-2">
                                            <a href="{{ route('sales.receipt', $row->id) }}"
                                                class="btn btn-link btn-fw btn-sm text-info p-0" title="View Tenant">
                                                <i class="ti-import"></i>
                                            </a>
                                        </div>
                                        @can('delete')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="{{ route('sales.destroy', $row->id) }}"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this sales?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-fw btn-sm text-danger p-0"><i
                                                            class="ti-trash" title="Delete Sales"></i></button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @php
                                $total += $row->amount;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No
                                    record
                                    found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total: </th>
                            <th>P {{ number_format($total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $sales->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @include('sales.modal')
@endsection

@push('footer-script')
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function getSales(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {

                    console.log(response)

                    $('#sales_id').val(response.id);
                    $('#transaction_date').val(response.transaction_date);;
                    $('#property_id').val(response.property_id);
                    $('#tenant_id').val(response.tenant_id);
                    $('#payment_method').val(response.payment_method);
                    $('#amount').val(response.amount);
                    $('#notes').val(response.notes);

                },
                error: function(xhr) {
                    // Handle the error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
