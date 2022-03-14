@component('mail::message')
    @lang('Dear') {{ $user->first_name }},

    @lang('We are pleased to inform you that your application for joining us as a Writer has been approved').

    @lang('You can use the following credentials to log in to our system').@lang('Please
make sure to change your password after you log in') .

@component('mail::table')
| @lang('Email') | @lang('Password') |
|:-----| -----:|
|{{ $user->email }}| {{ $password }}|

@endcomponent

@component('mail::button', ['url' => route('login')])
    @lang('Login')
@endcomponent

    @lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
