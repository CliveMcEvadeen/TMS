@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">

                <div class="card-body">
                    <h4 class="card-title">Tenant Details</h4>
                    <div class="border-bottom text-center pb-4">
                        <img src="{{ asset($rent->tenant->image ? 'storage/' . $rent->tenant->image : 'images/logo.png') }}"
                            alt="profile" class="img-fluid img-xl rounded-circle mb-3" width="200" />
                        <div class="mb-3">
                            <h3> {{ ucwords($rent->tenant->name) }}</h3>
                        </div>
                    </div>
                    <div class="py-4">
                        <p class="clearfix">
                            <span class="float-left">
                                Phone
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->tenant->contact_no }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Mail
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->tenant->email }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Address
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->tenant->address }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Rent Details</h4>
                    <div class="py-1">
                        <p class="clearfix">
                            <span class="float-left">
                                Property
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->property->property_name }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Status
                            </span>
                            <span class="float-right text-muted">
                                @php
                                    $badge = $rent->status == 'new' ? 'success' : 'info';
                                @endphp
                                <span class="badge badge-{{ $badge }}"> {{ ucwords($rent->status) }}
                                </span>
                                <button type="button" class="btn btn-link btn-fw btn-sm text-primary"
                                    data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Pay"
                                    data-target="#status" data-toggle="modal">
                                    <i class="ti-pencil"></i>
                                </button>
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Started Date
                            </span>
                            <span class="float-right text-muted">
                                {{ date('Y-m-d', strtotime($rent->start_date)) }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                End Date
                            </span>
                            <span class="float-right text-muted">
                                {{ date('Y-m-d', strtotime($rent->end_date)) }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Rent Type
                            </span>
                            <span class="float-right text-muted">
                                <span class="badge badge-primary"> {{ ucwords($rent->rent_type) }}</span>
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Terms
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->terms }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Payment Method
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->payment_method }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Penalty
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->penalty }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Discount
                            </span>
                            <span class="float-right text-muted">
                                {{ $rent->discount }} %
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Deposit
                            </span>
                            <span class="float-right text-muted">
                                {{ number_format($rent->deposit, 2) }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Amount
                            </span>
                            <span class="float-right text-muted">
                                {{ number_format($rent->amount, 2) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Payment Details</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Date Paid</th>
                                    <th>Status</th>
                                    <th class="hide-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rent->payments as $row)
                                    <tr>

                                        <td>{{ date('F', strtotime($row->due_date)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($row->due_date)) }}</td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
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
                                                        <button type="button"
                                                            class="btn btn-link btn-fw btn-sm text-primary"
                                                            onclick="createPayment({{ $row->id }})"
                                                            data-tooltip="tooltip" data-placement="bottom" title=""
                                                            data-original-title="Pay" data-target="#payment"
                                                            data-toggle="modal">
                                                            <i class="ti-wallet"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row pl-3">
                                                    <div class="col-auto p-0 mr-3">
                                                        <a href="{{ route('rents.receipt', $row->id) }}"
                                                            class="btn btn-link btn-fw btn-sm text-info"
                                                            data-tooltip="tooltip" data-placement="bottom" title="Receipt">
                                                            <i class="ti-import"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

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
                </div>
            </div>
        </div>
    </div>
    @include('rents.paymentModal')
@endsection

@push('footer-script')
    <script>
        function createPayment($id) {
            $('#payment_id').val($id)
        }
    </script>
@endpush
