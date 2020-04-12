<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DashBoard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix-core.js" defer></script>--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>
    <body>
        <div id="app">
             @include('Admin.layouts.navbar.navbar')
             @include('Admin.layouts.sidebar.sidebar')
             @yield('content')
        </div>
        @yield('js')
    </body>
</html>
