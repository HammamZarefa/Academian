<div class="card">
    <div class="card-body">
        <form action="{{ route('applicant_change_status', $applicant->id) }}" method="POST"
            autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Status</label>
                <?php echo form_dropdown("applicant_status_id", $data['statuses'], old('applicant_status_id', $applicant->applicant_status_id), "class='form-control form-control-sm  selectpicker'") ?>
                <div class="invalid-feedback d-block">
                    {{ showError($errors, 'applicant_status_id') }}</div>
            </div>
            <div class="form-group">
                <label>Note</label>
                <textarea class="form-control form-control-sm" rows="3" name="note">{{ $applicant->note }}</textarea>
                <div class="invalid-feedback d-block">
                    {{ showError($errors, 'applicant_status_id') }}</div>
            </div>
            <button type="submit" class="btn btn-secondary btn-sm btn-block">Change</button>
        </form>
    </div>
</div>
