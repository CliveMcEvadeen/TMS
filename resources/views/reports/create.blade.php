@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Report an Issue</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="issue_type">Issue Type</label>
            <select name="issue_type" class="form-control" required>
                <option value="">Select Issue Type</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Electrical">Electrical</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="urgency">Urgency</label>
            <select name="urgency" class="form-control" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit Report</button>
    </form>
</div>
@endsection
