<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script>document.documentElement.classList.add('js')</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans flex min-h-screen flex-col items-center bg-[#F7F6F2] text-slate-700">


    <!-- Content Start -->
    <div class="w-full px-15">
        @yield('content')
    </div>
    <!-- Content End -->

    <!-- Footer Start -->
    @if (request()->routeIs([
    'home',
    'facilities.show',
    ]))
        <div class="py-7">
            @include('layouts.partials.footer')
        </div>
    @endif
    <!-- Footer End -->

    <!-- Footer Start -->
    @if (request()->routeIs([
    'dashboard',
    'facilities.index',
    'bookings.*',
    'history.index',
    'notifications.index',
    'profile.edit',
    'admin.*',
    ]))
        <div class="w-full">
            @include('layouts.partials.footer2')
        </div>
    @endif
    <!-- Footer End -->

</body>

</html>