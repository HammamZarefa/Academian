<nav class="navbar navbar-expand-md shadow-sm navbar-background">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="logo" src="{{ get_company_logo() }}" alt="{{ config('app.name', 'Academian') }}" height="50px" width="50px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @role('admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">@lang('Dashboard')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders_list') }}">@lang('Orders')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users_list', ['type' => 'customer']) }}">@lang('Customers')</a>
                </li>
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="{{ route('users_list', ['type' => 'staff']) }}">--}}
                        {{--Writers--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item dropdown">
                    <a id="payments" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" v-pre>
                        @lang('Payments') <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="payments">
                        <a class="dropdown-item" href="{{ route('pending_payment_approvals') }}">@lang('Pending Approval')</a>
                        <a class="dropdown-item" href="{{ route('payments_list') }}">@lang('Payments List')</a>
                        <a class="dropdown-item" href="{{ route('wallet_transactions') }}">@lang('Wallet Transactions')</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a id="blog" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" v-pre>
                        @lang('Blog') <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="payments">
                        <a class="dropdown-item" href="{{ route('posts') }}">@lang('Blog')</a>
                        <a class="dropdown-item" href="{{ route('post_categories') }}">@lang('Categories')</a>
                        <a class="dropdown-item" href="{{ route('post_tags') }}">@lang('Tag')</a>
                        <a class="dropdown-item" href="{{ route('wallet_transactions') }}">@lang('Trash')</a>
                    </div>
                </li>


                {{--<li class="nav-item dropdown">--}}
                    {{--<a id="managerial" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"--}}
                       {{--aria-haspopup="true" aria-expanded="false" v-pre>--}}
                        {{--Manage <span class="caret"></span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu" aria-labelledby="managerial">--}}
                        {{--<a class="dropdown-item" href="{{ route('bills_list') }}">Bills from Writers</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('settings_main_page') }}">Settings</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('users_list', ['type' => 'admin']) }}">Admin Users</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('job_applicants') }}">Job Applicants</a>--}}
                    {{--</div>--}}
                {{--</li>--}}
                <li class="nav-item dropdown">
                    <a id="managerial" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" v-pre>
                        @lang('Reports') <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="managerial">
                        <a class="dropdown-item" href="{{ route('income_statement') }}">@lang('Income Statement')</a>
                        <a class="dropdown-item" href="{{ route('total_wallet_balance') }}">@lang('Total Wallet Balance')</a>

                    </div>
                </li>

                @endrole
                @role('staff')
                @if(strtolower(settings('enable_browsing_work')) == 'yes')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('browse_work') }}">@lang('Browse Work')</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tasks_list') }}">@lang('My Tasks')</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="payment_request" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @lang('Payment Request') <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="payment_request">
                        <a class="dropdown-item" href="{{ route('request_for_payment') }}">
                            @lang('Request for payment')
                        </a>
                        <a class="dropdown-item" href="{{ route('my_requests_for_payment') }}">
                            @lang('List of payment requests')
                        </a>
                    </div>
                </li>
                @endrole
                @auth
                    @unlessrole('staff|admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my_orders') }}">@lang('My Orders')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order_page') }}">@lang('New Order')</a>
                    </li>
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{ route('my_account',['group' => 'wallet']) }}">My Wallet</a>--}}
                    {{--</li>--}}
                    @endunlessrole
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto">
                @guest
                    @if(!settings('disable_writer_application'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('writer_application_page') }}">
                                {{ settings('writer_application_page_link_title') }}
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @hasanyrole('staff|admin')
                    <li class="nav-item dropdown" style="z-index: 2000 !important;">
                        @include('layouts.notification_bell')
                    </li>
                    @endhasanyrole
                    <li class="nav-item dropdown" style="z-index: 2000 !important;">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->first_name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ route('my_account') }}">
                                @lang('My Account')
                            </a>
                            @hasanyrole('staff|admin')
                            <a class="dropdown-item" href="{{ route('my_account',['group' => 'wallet']) }}">
                                @lang('My Wallet') </a>
                            <a class="dropdown-item" href="{{ route('my_orders') }}">@lang('My Orders')</a>
                            <a class="dropdown-item" href="{{ route('order_page') }}">@lang('New Order')</a>

                            <div class="dropdown-divider"></div>
                            @endhasanyrole
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
