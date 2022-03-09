<section class="header-account-page pt-100 d-flex align-items-end navbar-background" data-offset-top="#header-main">
    <div class="container pt-4 pt-lg-0">
        <div class="row justify-content-end">
            <div class=" col-lg-8">
                <div class="row align-items-center mb-4">
                    <div class="col-lg-8 col-xl-5 mb-4 mb-md-0">
                        <span class="h2 mb-0 text-white d-block">Hi, {{ $user->full_name }}</span>
                    </div>
                    <div class="col-auto flex-fill d-none d-xl-block">
                        <ul class="list-inline row justify-content-lg-end mb-0">
                            <li class="list-inline-item col-sm-4 col-md-auto px-3 my-2 mx-0">
                                <span class="badge badge-dot text-white">
                                    <i class="fas fa-wallet"></i> Wallet Balance
                                </span>
                                <a class="d-sm-block h5 text-white font-weight-bold pl-2" href="#">
                                    {{ format_money(auth()->user()->wallet()->balance()) }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Account navigation -->
                <div class="d-flex">
                    <div class="btn-group btn-group-nav shadow ml-auto" role="group" aria-label="Basic example">

                        <div class="btn-group" role="group">
                            <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon"
                                data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
                                <span class="btn-inner--icon"><i class="fas fa-wallet"></i></span>
                                <span class="btn-inner--text d-none d-sm-inline-block">My Wallet</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                aria-labelledby="btn-group-settings">
                                <a class="dropdown-item"
                                    href="{{ route('my_account', ['group' => 'wallet']) }}">Wallet
                                    Topup</a>
                                <a class="dropdown-item"
                                    href="{{ route('my_account', ['group' => 'payments']) }}">Payments</a>
                                <a class="dropdown-item"
                                    href="{{ route('my_account', ['group' => 'wallet-transactions']) }}">Transactions</a>
                            </div>
                        </div>

                        <div class="btn-group" role="group">
                            <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon"
                                data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
                                <span class="btn-inner--icon"><i class="far fa-address-card"></i></span>
                                <span class="btn-inner--text d-none d-sm-inline-block">Account</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                aria-labelledby="btn-group-settings">
                                <a class="dropdown-item"
                                    href="{{ route('my_account') }}?group=edit-profile">Edit
                                    Profile</a>
                                <a class="dropdown-item"
                                    href="{{ route('my_account') }}?group=change-password">Change
                                    Password</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
