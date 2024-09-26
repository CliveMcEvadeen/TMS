@extends('layouts.app')

@push('header-script')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endpush

@section('content')

    @include('partials.alert')

    <div class="container card">
User: <input type="text" name="tenant_id" value="{{ auth()->user()->id }}" readonly>

        <h2>Report an Issue</h2>

        <form action="{{ route('reports.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="issue_type">Issue Type</label>
                <select name="issue_type" class="form-control" required>
                    <option value="">Select Issue Type</option>
                    <option value="Plumbing">Plumbing</option>
                    <option value="Electrical">Electrical</option>
                    <option value="Security">Security</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="property_id">Room Number</label>
                <input type="text" name="property_id" class="form-control" placeholder="Enter room number" required>
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

@push('footer-script')
    <!-- Plugin js for this page-->
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script src="{{ asset('script/rent.js') }}"></script>
@endpush
