@php
    $hasUnread = auth()->check() && auth()->user()->hasUnreadBookingNotifications();
@endphp

<div class="ml-auto mb-5 flex items-center gap-6">

    {{-- NOTIFIKASI --}}
    <a
        href="{{ route('notifications.index') }}"
        aria-label="Notifikasi"
        class="group relative flex h-[50px] w-[30px] cursor-pointer items-center justify-center"
    >
        <img
            src="{{ asset('image/nontification.png') }}"
            alt="Notifikasi"
            @class([
                'h-[40px] w-[40px] origin-top object-contain transition-transform duration-300 group-hover:rotate-12',
                'animate-bell' => $hasUnread,
            ])
        >

        {{-- titik notifikasi: hanya muncul kalau ada notifikasi yang belum dibaca --}}
        @if ($hasUnread)
            <span class="absolute right-0 top-[9px] flex h-[6px] w-[6px]">
                <span class="absolute inline-flex h-full w-full animate-soft-ping rounded-full bg-[#639178] opacity-75"></span>
                <span class="relative inline-flex h-[6px] w-[6px] rounded-full bg-[#639178]"></span>
            </span>
        @endif
    </a>

    {{-- PROFILE --}}
    <a
        href="{{ route('profile.edit') }}"
        aria-label="Profil saya"
        class="flex h-[65px] w-[65px] cursor-pointer items-center justify-center border-0 bg-transparent p-0"
    >
        <img
            src="{{ auth()->user()?->avatar_url ?? asset('image/profile.png') }}"
            alt="Foto profil pengguna"
            class="block h-[65px] w-[65px] rounded-full object-cover ring-0 ring-[#639178]/40 transition duration-300 hover:scale-105 hover:ring-4"
        >
    </a>

</div>
