@component('mail::message')
Dear {{ $user->first_name }},

We are pleased to inform you that your application for joining us as a Writer has been approved. 

You can use the following credentials to log in to our system. Please
make sure to change your password after you log in.

@component('mail::table')
| Email | Password |
|:-----| -----:| 
|{{ $user->email }}| {{ $password }}|

@endcomponent

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
