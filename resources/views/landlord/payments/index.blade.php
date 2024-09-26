{{-- resources/views/landlord/payments/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Tenant Payments</h2>

    {{-- Display all tenant payments --}}
    <table class="table">
        <thead>
            <tr>
                <th>Machant ID</th>
                <th>Tenant Name</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                <td>{{ $payment->payment_id }}</td>
                    <td>{{ $payment->tenant->name }}</td>
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
                        @if($payment->payment_status == 'pending')
                            {{-- Approve payment --}}
                            <form action="{{ route('payments.approve', $payment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Verify</button>
                            </form>

                            {{-- Reject payment --}}
                            <form action="{{ route('payments.reject', $payment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($payment->payment_status) }}</span>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
