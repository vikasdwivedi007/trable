@component('mail::message')
# You have a new notification {{$notifiable->name}}

<br>
<strong>{{$title}}</strong>
<br>
<br>
{{$desc}}

@component('mail::button', ['url' => route('login')])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

