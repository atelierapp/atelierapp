


@component('mail::message')
# Recover your password

Hi {{ $name }}! We have received a request to recover the password of your Atelier account.

To do so, please follow this link:

@component('mail::button', ['url' => route('resetPassword', ['token' => $token]), 'color' => 'success'])
    Update my password
@endcomponent

If this wasn't you, don't worry. Just ignore this email.

Best,<br>
The Atelier Team
@endcomponent