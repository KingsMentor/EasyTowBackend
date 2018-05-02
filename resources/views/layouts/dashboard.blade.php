<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EasyTow</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/logo.png') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ url('/admin/css/neat.min.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ url('/admin/form.css') }}">

</head>
<body>

<div class="o-page">
   <div class="alert alert-danger">
       Upload in progress
   </div>

</div>


<script src="{{ url('admin/js/neat.js') }}"></script>

</body>
</html>
