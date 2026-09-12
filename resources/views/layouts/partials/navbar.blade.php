@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';

    $tabs = auth()->check()
        ? [
            ['label' => 'Home', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')],
            ['label' => 'Facilities', 'route' => 'facilities.index', 'active' => request()->routeIs('facilities.*')],
            ['label' => 'Bookings', 'route' => 'bookings.index', 'active' => request()->routeIs('bookings.*')],
            ['label' => 'History', 'route' => 'history.index', 'active' => request()->routeIs('history.*')],
            $isAdmin
                ? [
                    'label' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'active' => request()->routeIs('admin.*') || request()->routeIs('profile.edit'),
                ]
                : [
                    'label' => 'Profile',
                    'route' => 'profile.edit',
                    'active' => request()->routeIs('profile.*'),
                ],
        ]
        : [
            ['label' => 'Home', 'route' => 'home', 'active' => request()->routeIs('home')],
            ['label' => 'Facilities', 'route' => 'facilities.index', 'active' => request()->routeIs('facilities.*')],
            ['label' => 'Login', 'route' => 'login', 'active' => request()->routeIs('login')],
        ];
@endphp

<nav class="flex items-end gap-1">
    @foreach ($tabs as $tab)
        <a href="{{ route($tab['route']) }}" class="
                flex w-[190px] items-center justify-center rounded-t-lg
                bg-[#303030] text-lg font-semibold text-white
                {{ $tab['active'] ? 'h-[84px]' : 'h-[42px]' }}
            ">
            {{ $tab['label'] }}
        </a>
    @endforeach
</nav>
