@component('mail::message')
    Hello {{$email}}!
    	Your password has been reset successfully.
    Thanks,
    {{ config('app.name') }}
@endcomponent
