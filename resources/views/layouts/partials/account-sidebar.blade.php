@php
    $accountUser = auth()->user();
    $isAdminSidebar = $accountUser->role === 'admin';
@endphp

<aside class="w-[240px] shrink-0">

    <div class="flex flex-col items-center">
        <div class="h-[190px] w-[190px] overflow-hidden rounded-full bg-[#f5f5f5]/10">
            <img
                src="{{ $accountUser->avatar_url ?? asset('image/transparan.png') }}"
                alt="{{ $accountUser->name }}"
                class="h-full w-full object-cover"
            >
        </div>
        <p class="mt-4 text-[26px] font-semibold text-white">
            {{ $isAdminSidebar ? 'Admin' : 'Student' }}
        </p>
    </div>

    <nav class="mt-10 flex flex-col gap-2">

        <a href="{{ route('profile.edit') }}" class="
                flex items-center gap-3 rounded-md px-4 py-3 text-[16px] font-medium transition
                {{ request()->routeIs('profile.edit') ? 'bg-[#639178] text-white' : 'text-white/80 hover:bg-white/5' }}
            ">
            <img src="{{ asset('image/profile-icon.png') }}" alt="">
            Personal Information
        </a>

        @if ($isAdminSidebar)
            <a href="{{ route('admin.bookings.index') }}" class="
                    flex items-center gap-3 rounded-md px-4 py-3 text-[16px] font-medium transition
                    {{ request()->routeIs('admin.bookings.*') ? 'bg-[#639178] text-white' : 'text-white/80 hover:bg-white/5' }}
                ">
                <img src="{{ asset('image/calendar-icon-white.png') }}" alt="">
                Booking Requests
            </a>

            <a href="{{ route('admin.facilities.index') }}" class="
                    flex items-center gap-3 rounded-md px-4 py-3 text-[16px] font-medium transition
                    {{ request()->routeIs('admin.facilities.*') ? 'bg-[#639178] text-white' : 'text-white/80 hover:bg-white/5' }}
                ">
                <img src="{{ asset('image/building-icon-white.png') }}" alt="">
                Facilities
            </a>

            <a href="{{ route('admin.users.index') }}" class="
                    flex items-center gap-3 rounded-md px-4 py-3 text-[16px] font-medium transition
                    {{ request()->routeIs('admin.users.*') ? 'bg-[#639178] text-white' : 'text-white/80 hover:bg-white/5' }}
                ">
                <img src="{{ asset('image/users-icon-white.png') }}" alt="">
                Users
            </a>
        @endif

        <hr class="my-2 border-white/10">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-md px-4 py-3 text-left text-[16px] font-medium text-white/80 transition hover:bg-white/5">
                <img src="{{ asset('image/logout-icon.png') }}" alt="">
                Log Out
            </button>
        </form>

    </nav>

</aside>
