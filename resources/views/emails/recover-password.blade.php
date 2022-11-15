


@component('mail::message')
# {{ __('email.recover-your-password') }}

{{ __('email.we-received-a-message-to-recover-your-password', ['name' => $name]) }}

{{ __('email.follow-this-link') }}

@component('mail::button', ['url' => "https://app.atelierapp.com/recover-password?token=$token", 'color' => 'success'])
    {{ __('email.update-my-password') }}
@endcomponent

{{ __('email.if-this-was-not-you') }}

{{ __('email.best') }},<br>
The Atelier Team
@endcomponent