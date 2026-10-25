{{--
    Search bar untuk halaman Bookings & History.
    Form-nya kosong dan dihubungkan lewat atribut form="booking-filter-form",
    jadi search + filter (yang letaknya terpisah di layout) tetap terkirim bersamaan.
--}}
<form id="booking-filter-form" method="GET" action="{{ url()->current() }}"></form>

<section class="flex w-full items-start justify-between pt-[35px]">
    <div class="flex h-[50px] w-full items-center rounded-lg bg-white px-[15px]">

        <input
            type="text"
            name="search"
            form="booking-filter-form"
            value="{{ request('search') }}"
            placeholder="Search..."
            class="h-full flex-1 bg-transparent text-[14px] text-[#343434] placeholder-gray-400 outline-none"
        >

        <button type="submit" form="booking-filter-form" aria-label="Search" class="ml-auto">
            <img
                src="{{ asset('image/search-icon.png') }}"
                alt="Search"
                class="h-[22px] w-[22px] object-contain"
            >
        </button>

    </div>
</section>
