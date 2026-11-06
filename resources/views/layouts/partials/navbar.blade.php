{{--
    Navbar atas (tab). Parameter opsional:
      $tabBg => kelas warna latar tab (default bg-[#303030]); halaman yang panelnya
                memakai warna lain mengirim mis. 'bg-[#343434]' supaya tab & panel menyatu.
--}}
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    $tabBg = $tabBg ?? 'bg-[#303030]';

    $tabs = auth()->check()
        ? [
            // halaman Notifications (lonceng) juga menyorot tab Home, sesuai wireframe
            ['label' => 'Home', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard') || request()->routeIs('notifications.*')],
            ['label' => 'Facilities', 'route' => 'facilities.index', 'active' => request()->routeIs('facilities.*')],
            ['label' => 'Bookings', 'route' => 'bookings.index', 'active' => request()->routeIs('bookings.*')],
            ['label' => 'History', 'route' => 'history.index', 'active' => request()->routeIs('history.*')],
            $isAdmin
                ? [
                    'label' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    // tetap menyala di halaman Personal Information ATAU halaman admin manapun
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
        <a
            href="{{ route($tab['route']) }}"
            style="animation-delay: {{ $loop->index * 70 }}ms"
            @class([
                'flex w-[190px] animate-fade-up items-center justify-center rounded-t-lg text-lg font-semibold text-white transition-[height,filter] duration-300 ease-out',
                $tabBg,
                'h-[84px]' => $tab['active'],
                'h-[42px] hover:h-[52px] hover:brightness-125' => ! $tab['active'],
            ])
        >
            {{ $tab['label'] }}
        </a>
    @endforeach
</nav>
