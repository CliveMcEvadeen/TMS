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
                <th>Submission Time</th> <!-- Include submission time -->
                @role('rental-admin')
                <th>Actions</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->complaint_code }}</td>
                    <td>{{ $complaint->tenant->name }}</td>
                    <td>{{ $complaint->room_number }}</td>
                    <td>{{ $complaint->block }}</td>
                    <td>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#descriptionModal{{ $complaint->complaint_code }}">
                            View Complaint
                        </button>
                        @include('complaints.description-modal', ['complaint' => $complaint])
                    </td>
                    <td>
                        @role('rental-admin|rental-staff')
                            @if($complaint->status == 'pending')
                                <span class="badge bg-warning text-dark">{{ ucfirst($complaint->status) }}</span>
                            @elseif($complaint->status == 'resolved')
                                <span class="badge bg-success">{{ ucfirst($complaint->status) }}</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($complaint->status) }}</span>
                            @endif
                        @endrole
                    </td>
                    <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td> <!-- Display submission time -->
                    <td>
                        @role('rental-admin')
                            @if($complaint->status == 'pending')
                                <form action="{{ route('complaints.resolve', $complaint->complaint_code) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Resolve</button>
                                </form>
                            @else
                                <span class="text-muted">Resolved</span>
                            @endif
                        @endrole
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
