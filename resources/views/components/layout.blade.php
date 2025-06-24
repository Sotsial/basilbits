<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />
</head>

<body>
    <x-header></x-header>
    <main>{{ $slot }}</main>
    <x-footer></x-footer>
    <script src="{{ asset('js/popup.js') }}"></script>
</body>

</html>