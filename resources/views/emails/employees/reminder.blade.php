@component('mail::message')
# You have a new reminder {{$reminder->assigned_to->user->name}}

<br>
<strong>{{$reminder->title}}</strong>
<br>
<br>
{{$reminder->desc}}

@component('mail::button', ['url' => route('login')])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

