@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="receipt-box p-4 border rounded">
            <h2 class="text-center">Payment Receipt</h2>
            <hr>

            <table class="table table-bordered mt-4">
                <tbody>
                    <tr>
                        <th class="text-end" width="40%">Payment ID:</th>
                        <td>{{ $payment->payment_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Tenant Name:</th>
                        <td>{{ $payment->tenant->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Tenant Contact:</th>
                        <td>{{ $payment->tenant->contact_no }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Payment Amount:</th>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Payment Method:</th>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Date of Payment:</th>
                        <td>{{ $payment->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 text-center">
                <h5>Thank you for your payment!</h5>
                <button class="btn btn-primary mt-2" onclick="window.print()">Print Receipt</button>
            </div>
        </div>
    </div>
@endsection
