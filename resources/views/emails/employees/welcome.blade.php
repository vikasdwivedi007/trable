@component('mail::message')
# Welcome {{$employee->user->name}}

<br>
Here are your credentials that you can use to login to our system and access your account.
<br>
<br>
<strong>email:</strong> {{$employee->user->email}}
<br>
<strong>password:</strong> {{$password}}

@component('mail::button', ['url' => route('login')])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

