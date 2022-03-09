<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Wallet Topup</h5>
            </div>
            <div class="col-md-6">
                <h5 class="card-title text-right">Current Balance:
                    {{ format_money(auth()->user()->wallet()->balance()) }}</h5>
            </div>
        </div>

        <form action="{{ route('my_wallet_topup') }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control {{ showErrorClass($errors, 'amount') }}" name="amount" value="{{ old('amount') }}">
                <div class="invalid-feedback d-block">{{ showError($errors, 'amount') }}</div>
            </div>
            <button type="submit" class="btn btn-success">Choose payment option</button>
        </form>

    </div>
</div>
