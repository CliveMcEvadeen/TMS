@extends('layouts.app')

@section('content')
    <div class="text-right mb-2">
        @if (auth()->user()->hasRole('rental-admin'))
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-tooltip="tooltip"
                data-target="#filter_date" title="Filter Date">
                <i class="ti-filter"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal"
                onclick="location.href='{{ url()->current() }}'" title="Reload">
                <i class="ti-reload"></i>
            </button>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="tableToPDF('paymentTable')"
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
                        Add, edit, and remove paymemnts.
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
                <table class="table table-striped table-borderless" id="paymentTable">
                    <thead>
                        <tr>
                            <th>Tenant</th>
                            <th>Due Date</th>
                            <th>Covered Month</th>
                            <th>Amount</th>
                            <th>Date Paid</th>
                            <th>Status</th>
                            <th class="hide-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $row)
                            <tr>
                                <td><a
                                        href="{{ route('tenants.view', $row->rent->tenant->id) }}">{{ $row->rent->tenant->name }}</a>
                                </td>
                                <td>{{ date('d M Y', strtotime($row->due_date)) }}</td>
                                <td>{{ date('F', strtotime($row->due_date)) ?? '' }}</td>
                                <td class="font-weight-bold">P {{ $row->amount }}</td>
                                <td>{{ $row->status ? date('Y-m-d', strtotime($row->date_paid)) : '' }}</td>
                                <td>
                                    @php
                                        $badge = $row->status ? 'success' : 'danger';
                                    @endphp
                                    <span class="badge badge-{{ $badge }}">
                                        {{ $row->status ? 'settled' : 'Unsettled' }}
                                    </span>
                                </td>
                                <td>
                                    @if (!$row->status)
                                        <div class="row pl-3">
                                            <div class="col-auto p-0 mr-3">
                                                <button type="button" class="btn btn-link btn-fw btn-sm text-primary"
                                                    onclick="createPayment({{ $row->id }})" data-tooltip="tooltip"
                                                    data-placement="bottom" title="" data-original-title="Pay"
                                                    data-target="#payment" data-toggle="modal">
                                                    <i class="ti-wallet"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row pl-3">
                                            <div class="col-auto p-0 mr-3">
                                                <a href="{{ route('rents.receipt', $row->id) }}"
                                                    class="btn btn-link btn-fw btn-sm text-info" data-tooltip="tooltip"
                                                    data-placement="bottom" title="Receipt">
                                                    <i class="ti-import"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="ti-dropbox" style="font-size: 100px; color:gray;"></i> <br> No record
                                    found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav class="mt-5">
                <ul class="pagination flex-wrap pagination-flat pagination-primary justify-content-end">
                    {{ $payments->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @include('payments.modal')
@endsection

@push('footer-script')
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function createPayment(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {

                    $('#payment_id').val(response.id);
                    $('#tenant').val(response.tenant_name);;
                    $('#amount').val(response.amount);

                },
                error: function(xhr) {
                    // Handle the error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
