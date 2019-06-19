<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="Creative Tim">
    <title>Radio</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Argon CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet">

    <base href="https://demos.creative-tim.com/argon-dashboard-pro/pages/examples/">
</head>

<body class="@yield('body-class')">
<!-- Navbar -->
<!-- Main content -->
<main class="main-content">
    @yield('content')
</main>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/vendor.min.js') }}"></script>
</body>

</html>