<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" required class="form-control" name="name" placeholder="Name"
                            value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" class="form-control" name="contact_no" value="{{ old('contact_no') }}"
                            placeholder="Contact Number">
                        @error('contact_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" value="{{ old('email') }}" name="email" required
                            placeholder="Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" required>
                            @foreach ($roles as $role)
                                @if (auth()->user()->hasRole('rental-manager'))
                                    @if ($role->name != 'rental-admin')
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @else
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" method="POST" action="{{ route('users.update') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" required class="form-control" name="name" id="name"
                            value="{{ old('name') }}" placeholder="Name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no"
                            value="{{ old('contact_no') }}" placeholder="Contact Number">
                        @error('contact_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" value="{{ old('email') }}" name="email" required
                            id="email" placeholder="Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role_id" required>
                        @foreach ($roles as $role)
                            @if ($role->name !== 'rental-admin')
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @endforeach

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user_id" name="user_id">
                    <button type="submit" class="btn btn-success"> Update</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
