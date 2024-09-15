<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Create Sales </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('sales.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Transaction Date</label>
                        <input type="date" class="form-control" name="transaction_date"
                            value="{{ old('transaction_date') ? old('transaction_date') : date('Y-m-d') }}">
                        @error('transaction_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Property</label>
                        <select name="property_id" class="form-control" required>
                            <option value="">Select property</option>
                            @foreach ($properties as $row)
                                <option value="{{ $row->id }}">{{ $row->property_name }}</option>
                            @endforeach

                        </select>
                        @error('property_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sold to</label>
                        <select name="tenant_id" class="form-control" required>
                            <option value="">Select tenant</option>
                            @foreach ($tenants as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach

                        </select>
                        @error('tenant_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option>cash</option>
                            <option>check</option>
                        </select>
                        @error('payment_method')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" name="amount" value="{{ old('amount') }}"
                            placeholder="Enter amount">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <input type="text" class="form-control" name="notes" value="{{ old('notes') }}"
                            placeholder="Enter notes">
                        @error('notes')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
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

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Edit Sales </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('sales.update') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Transaction Date</label>
                        <input type="date" class="form-control" name="transaction_date" id="transaction_date"
                            value="{{ old('transaction_date') ? old('transaction_date') : date('Y-m-d') }}">
                        @error('transaction_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Property</label>
                        <select name="property_id" class="form-control" required id="property_id">
                            <option value="">Select property</option>
                            @foreach ($properties as $row)
                                <option value="{{ $row->id }}">{{ $row->property_name }}</option>
                            @endforeach

                        </select>
                        @error('property_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sold to</label>
                        <select name="tenant_id" class="form-control" required id="tenant_id">
                            <option value="">Select tenant</option>
                            @foreach ($tenants as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach

                        </select>
                        @error('tenant_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control" required id="payment_method">
                            <option>cash</option>
                            <option>check</option>
                        </select>
                        @error('payment_method')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" name="amount" value="{{ old('amount') }}"
                            placeholder="Enter amount" id="amount">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <input type="text" class="form-control" name="notes" value="{{ old('notes') }}"
                            placeholder="Enter notes" id="notes">
                        @error('notes')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="sales_id" id="sales_id">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="filter_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Filter By Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" class="form-control" name="from_date" id="from_date"
                            value="{{ isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" class="form-control" name="to_date" id="to_date"
                            value="{{ isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
