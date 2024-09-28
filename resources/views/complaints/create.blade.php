{{-- resources/views/complaints/form.blade.php --}}

@extends('layouts.app')

@section('content')
<p>Authenticated User ID: {{ Auth::id() }}</p>
<form action="{{ route('complaints.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="room_number" class="form-label">Room Number</label>
        <input type="text" class="form-control" name="room_number" required>
    </div>

    <div class="mb-3">
        <label for="block" class="form-label">Block</label>
        <input type="text" class="form-control" name="block" required>
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" name="location" required>
    </div>

    <div class="mb-3">
        <label for="telephone_number" class="form-label">Telephone Number</label>
        <input type="text" class="form-control" name="telephone_number" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description of Issue</label>
        <textarea class="form-control" name="description" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit Complaint</button>
</form>
@endsection
