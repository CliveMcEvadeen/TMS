<!-- Modal for complaint description -->
<div class="modal fade" id="descriptionModal{{ $complaint->complaint_code }}" tabindex="-1" aria-labelledby="descriptionModalLabel{{ $complaint->complaint_code }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white h1">

                <h5 class="modal-title" id="descriptionModalLabel{{ $complaint->complaint_code }}">Complaint Description</h5>
                <button type="button" class="btn-close  btn btn-info" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto; font-size: 16px; line-height: 1.5; white-space: pre-wrap;">
                <p class="fw-normal">{{ $complaint->description }}</p>
            </div>
            
        </div>
    </div>
</div>
