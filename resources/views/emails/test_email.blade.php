@component('mail::message')

    @lang('Hi'),

    @lang('Congratulation! Your email is configured correctly').


    @lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
