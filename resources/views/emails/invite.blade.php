@component('mail::message')

    @lang('Hi'),

    @lang('Congratulation! You have been invited to join') {{ settings('company_name') }} as {{ $role_name }} ! @lang('Please click the button below to confirm your joining').

@component('mail::button', ['url' => route('register', ['c' => $ref_code ])])
    @lang('Join Now')
@endcomponent

    @lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
