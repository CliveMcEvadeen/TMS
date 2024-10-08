{{-- resources/views/payments/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Payment History</h2>

    {{-- Display payment history --}}
    <table class="table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                <td>{{ $payment->payment_id }}</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>
                        @if($payment->payment_status == 'pending')
                            <span class="badge bg-warning">{{ ucfirst($payment->payment_status) }}</span>
                        @elseif($payment->payment_status == 'approved')
                            <span class="badge bg-success">{{ ucfirst($payment->payment_status) }}</span>
                        @else
                            <span class="badge bg-danger">{{ ucfirst($payment->payment_status) }}</span>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                    <td>

                    @if($payment->payment_status == 'approved')
                    <td>
                    <a href="{{ route('payments.receipt', $payment->payment_id) }}" class="btn btn-primary">Download Receipt</a>

                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Button to make a new payment --}}

    {{-- Include the payment form modal --}}
    @include('payments.form')
    @include('payments.payment-modal')
</div>
@endsection
