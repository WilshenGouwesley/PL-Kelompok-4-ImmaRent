{{--
    Baris "Filter by: Date | Category | Status | Reset Filter" untuk Bookings & History.
    Butuh variabel $categories (daftar kategori fasilitas) dari controller.
    Dropdown langsung submit saat diganti.
--}}
@php
    $pill = 'relative flex h-[26px] items-center rounded-full bg-[#f5f5f5]';
    $field = 'h-full w-full appearance-none rounded-full bg-transparent pl-[14px] pr-[34px] text-[15px] text-[#343434] outline-none';
    $statuses = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'];
@endphp

<div class="flex w-full items-center justify-between pt-[15px]">

    <div class="flex items-center gap-[15px]">

        <p class="text-[15px] text-white">Filter by:</p>

        {{-- DATE --}}
        <div class="{{ $pill }} w-[165px]">
            <input
                type="date"
                name="date"
                form="booking-filter-form"
                value="{{ request('date') }}"
                onchange="this.form.submit()"
                title="Date"
                aria-label="Date"
                class="h-full w-full rounded-full bg-transparent px-[14px] text-[15px] text-[#343434] outline-none"
            >
        </div>

        {{-- CATEGORY --}}
        <div class="{{ $pill }} w-[150px]">
            <select
                name="category"
                form="booking-filter-form"
                onchange="this.form.submit()"
                aria-label="Category"
                class="{{ $field }}"
            >
                <option value="">Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <img
                src="{{ asset('image/arrow-down-icon.png') }}"
                alt=""
                class="pointer-events-none absolute right-[14px] h-[15px] w-[15px] object-contain"
            >
        </div>

        {{-- STATUS --}}
        <div class="{{ $pill }} w-[140px]">
            <select
                name="status"
                form="booking-filter-form"
                onchange="this.form.submit()"
                aria-label="Status"
                class="{{ $field }}"
            >
                <option value="">Status</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <img
                src="{{ asset('image/arrow-down-icon.png') }}"
                alt=""
                class="pointer-events-none absolute right-[14px] h-[15px] w-[15px] object-contain"
            >
        </div>

    </div>

    {{-- RESET FILTER --}}
    <a
        href="{{ url()->current() }}"
        class="flex h-[35px] w-[140px] items-center justify-center gap-[7px] rounded-sm bg-[#639178]"
    >
        <img src="{{ asset('image/refresh-icon.png') }}" alt="" class="h-[20px] w-[20px]">
        <span class="text-[15px] text-white">Reset Filter</span>
    </a>

</div>
