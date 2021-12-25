<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>テストチャット</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="app">
        <chat-component></chat-component>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>