<x-mail::message>
    # Hello, {{ $firstName }}

    {{ $message }}

    Best regards,
    Maverick Writers

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
