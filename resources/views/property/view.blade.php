@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">

                <div class="card-body">
                    <h4 class="card-title">Property Details</h4>
                    <div class="border-bottom text-center pb-4">
                        <img src="{{ asset($property->image ? 'storage/' . $property->image : 'images/logo.png') }}"
                            class="img-fluid img-xl rounded-circle mb-3" width="200" />
                        <div class="mb-3">
                            <h3> {{ ucwords($property->property_name) }}</h3>
                            <span class="badge badge-primary"> {{ $property->status }}</span>
                        </div>
                    </div>
                    <div class="py-4">
                        <p class="clearfix">
                            <span class="float-left">
                                Owner
                            </span>
                            <span class="float-right text-muted">
                                {{ $property->owner->name }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Location
                            </span>
                            <span class="float-right text-muted">
                                {{ $property->location }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Price
                            </span>
                            <span class="float-right text-muted">
                                {{ $property->price }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Monthly
                            </span>
                            <span class="float-right text-muted">
                                {{ $property->monthly }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Yearly
                            </span>
                            <span class="float-right text-muted">
                                {{ $property->yearly }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Rent History</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Tenant</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($property->properties as $row)
                                    <tr>
                                        <td>{{ $row->tenant->name }}</td>
                                        <td>{{ date('Y-m-d', strtotime($row->start_date)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($row->end_date)) }}</td>
                                        <td>
                                            @php
                                                $badge = $row->status == 'active' ? 'success' : 'info';
                                            @endphp
                                            <span class="badge badge-{{ $badge }}">
                                                {{ $row->status ? 'settled' : 'Unsettled' }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                    </tr>
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
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-4">

                <div class="card-body">
                    <h4 class="card-title">Sales History</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Covered Month</th>
                                    <th>Property</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($property->sales as $row)
                                    <tr>
                                        <td>{{ date('Y-m-d', strtotime($row->transaction_date)) }}</td>
                                        <td>{{ date('F', strtotime($row->payment->due_date)) ?? '' }}</td>
                                        <td>{{ $row->property->property_name ?? $row->payment->rent->property->property_name }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $row->status ? 'success' : 'warning' }}">
                                                {{ $row->status ? 'completed' : 'pending' }}</span>
                                        </td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                    </tr>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
