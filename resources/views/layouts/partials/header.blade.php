<div class="ml-auto mb-5 flex items-center gap-6">

    {{-- NOTIFIKASI --}}
    <a
    href="{{ route('notifications.index') }}"
    aria-label="Notifikasi"
    class="relative flex h-[50px] w-[30px] cursor-pointer items-center justify-center"
    >

            <img
                src="{{ asset('image/nontification.png') }}"
                alt="Notifikasi"
                class="h-[40px] w-[40px] object-contain"
            >

            {{-- titik notifikasi --}}
            <span
                class="absolute right-0 top-[9px] h-[6px] w-[6px] rounded-full bg-[#639178]"
            ></span>

    </a>


    {{-- PROFILE --}}
    <a
        href="{{ route('profile.edit') }}"
        aria-label="Profil saya"
        class="flex h-[65px] w-[65px] cursor-pointer items-center justify-center border-0 bg-transparent p-0"
    >

        <img
            src="{{ asset('image/profile.png') }}"
            alt="Foto profil pengguna"
            class="block h-[65px] w-[65px] rounded-full object-cover"
        >

    </a>

</div>