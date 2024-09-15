@php
    $settings = App\Models\Settings::get()->keyBy('key');
@endphp

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome to {{ $settings['site_sys_name']->value }}!</h3>
                    <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="justify-content-end d-flex">
                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today ({{ date('d M Y') }})
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Number of Rentals</p>
                    <p class="fs-30 mb-2">{{ number_format($rents) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Number of Properties</p>
                    <p class="fs-30 mb-2">{{ number_format($properties) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Number of Tenants</p>
                    <p class="fs-30 mb-2">{{ number_format($tenants) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Number of Landlords</p>
                    <p class="fs-30 mb-2">{{ number_format($owners) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Cards Section -->
    <div class="row">
        <!-- <div class="col-md-6 mb-4 mt-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Today's Sales</p>
                    <p class="fs-30 mb-2">P {{ number_format($today_sales, 2) }}</p>
                </div>
            </div>
        </div> -->
        <div class="col-md-6 mb-4 mt-4 stretch-card transparent">
            <!-- <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Total Sales</p>
                    <p class="fs-30 mb-2">P {{ number_format($total_sales, 2) }}</p>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Payment Overdue Section -->
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Payment Overdue</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Tenant</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($due_payments as $row)
                                    <tr>
                                        <td>{{ $row->rent->tenant->name }}</td>
                                        <td>{{ date('d M Y', strtotime($row->due_date)) }}</td>
                                        <td class="font-weight-bold">P {{ $row->amount }}</td>
                                        <td class="font-weight-medium">
                                            <div class="badge badge-danger">Unsettled</div>
                                        </td>
                                        <td>
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
                            {{ $due_payments->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Rent Report Section -->
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Rent Report</h4>
                    <canvas id="north-america-chart"></canvas>
                    <div id="north-america-legend"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Report Section -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <p class="card-title">Sales Report</p>
                <a href="{{ route('sales') }}" class="text-info">View all</a>
            </div>
            <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
            <canvas id="sales-chart"></canvas>
        </div>
    </div>

    @include('admin.modal')
@endsection

@push('footer-script')
    <script src="{{ asset('script/chart.js') }}"></script>
    <script src="{{ asset('js/Chart.roundedBarCharts.js') }}"></script>
    <script>
        var currentURL = (window.location.href).split('?')[0];

        function createPayment(id) {
            $.get({
                url: currentURL + "/" + id,
                success: function(response) {
                    $('#payment_id').val(response.id);
                    $('#tenant').val(response.tenant_name);
                    $('#amount').val(response.amount);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function fetchSalesData() {
            $.get({
                url: currentURL + "/sales/data",
                success: function(response) {
                    SalesChart.data.datasets[0].data = response.current_sale;
                    SalesChart.data.datasets[1].data = response.previous_sale;
                    SalesChart.update();
                    document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function fetchPropertiesData() {
            $.get({
                url: currentURL + "/properties/data",
                success: function(response) {
                    northAmericaChart.data.datasets[0].data = [response.sold, response.vacant, response.rented];
                    northAmericaChart.update();
                    document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        fetchSalesData();
        fetchPropertiesData();
    </script>
@endpush
