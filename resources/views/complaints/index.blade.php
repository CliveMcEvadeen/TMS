{{-- resources/views/complaints/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Complaints</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Complaint Code</th>
                <th>Tenant Name</th>
                <th>Room Number</th>
                <th>Block</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->complaint_code }}</td>
                    <td>{{ $complaint->tenant->name }}</td>
                    <td>{{ $complaint->room_number }}</td>
                    <td>{{ $complaint->block }}</td>
                    <td>{{ $complaint->description }}</td>
                    <td>{{ ucfirst($complaint->status) }}</td>
                    <td>
                        @if($complaint->status == 'pending' && Auth::user()->isLandlord())
                            <form action="{{ route('complaints.resolve', $complaint->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Mark as Resolved</button>
                            </form>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($complaint->status) }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
