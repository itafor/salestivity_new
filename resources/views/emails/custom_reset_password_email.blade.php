@component('mail::message')
    Hello!
You are receiving this email because we received a password reset request for your account.
    @component('mail::button', ['url' => $link])
        Reset Password
    @endcomponent
If you did not request a password reset, no further action is required.

    Thanks,
    {{ config('app.name') }}


If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <a href="{{$link}}" target="_blank">{{$link}}</a>
@endcomponent
