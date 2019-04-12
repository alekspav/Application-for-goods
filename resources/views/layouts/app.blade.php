<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Корпоративный портал</title>
    <link rel="stylesheet" href="{{ url('/css/app.css') }}">
    <link rel="stylesheet" href="/css/@yield('css', 'app').css">

    <!-- Scripts -->
    <link rel="preload" href="{{ url('/js/app.js') }}" as="script">

</head>
<body>


<div id="app">
    @yield('content')
</div>

<script src="{{ url('/js/app.js') }}"></script>

@yield('footer')
</body>
</html>