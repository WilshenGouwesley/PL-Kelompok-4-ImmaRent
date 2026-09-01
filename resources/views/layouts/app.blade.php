<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col items-center bg-[#F7F6F2] text-slate-700">


    <!-- Content Start -->
    <div class="w-full px-15">
        @yield('content')
    </div>
    <!-- Content End -->

    <!-- Footer Start -->
    @include('layouts.partials.footer')
    <!-- Footer End -->

</body>

</html>