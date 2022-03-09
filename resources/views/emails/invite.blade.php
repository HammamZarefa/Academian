@component('mail::message')

Hi, 

Congratulation! You have been invited to join {{ settings('company_name') }} as {{ $role_name }} ! Please click the button below to confirm your joining.

@component('mail::button', ['url' => route('register', ['c' => $ref_code ])])
Join Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
