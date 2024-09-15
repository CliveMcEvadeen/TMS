<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Create Payment </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('rents.payment') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" required class="form-control" name="date_paid"
                            value="{{ date('Y-m-d') }}">
                        @error('date_paid')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tenant</label>
                        <input type="text" required class="form-control" name="tenant" placeholder="Tenant Name"
                            value="" id="tenant">
                        @error('tenant')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" required class="form-control" name="amount" id="amount"
                            placeholder="Property Name" value="">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="location">Penalty</label>
                        <input type="number" class="form-control" name="penalty" id="penalty"
                            placeholder="Enter penalty">
                        @error('penalty')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="payment_id" id="payment_id">
                    <button type="submit" class="btn btn-primary">Settle</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
