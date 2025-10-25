<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- START CSS -->
    <!-- Tailwind is included -->
    @include('layouts.admin.css')
    <!-- END CSS -->

    <!-- START JS -->
    @include('layouts.admin.js')
    <!-- END JS -->
</head>

<body>

    <div id="app">

        <!-- START HEADER -->
        @include('layouts.admin.header')
        <!-- END HEADER -->

        <!-- START SIDEBAR -->
        @include('layouts.admin.sidebar')
        <!-- END SIDEBAR -->

        <!-- START MAIN CONTENT -->
        @yield('content')
        <!-- END MAIN CONTENT -->

        <!-- START FOOTER -->
        @include('layouts.admin.footer')
        <!-- END FOOTER -->



</body>

</html>
