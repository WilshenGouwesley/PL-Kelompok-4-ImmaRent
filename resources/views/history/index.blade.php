@extends('layouts.app')

@section('title', 'History - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        {{-- ================= HEADER + NAVIGATION ================= --}}
        <div class="flex w-full items-end justify-between pt-4">

            @include('layouts.partials.navbar', ['tabBg' => 'bg-[#343434]'])

            {{-- HEADER --}}
            @include('layouts.partials.header')

        </div>


        {{-- ================= BODY ================= --}}
        <main class="w-full bg-[#343434] px-10">

            @include('layouts.partials.filter-search')

            {{-- ================= HISTORY SUMMARY ================= --}}
            <div class="flex w-full items-center justify-between pt-[15px]">

                {{-- ALL BOOKINGS --}}
                <div class="flex h-[92px] w-[270px]  items-center rounded-lg bg-[#639178] px-[30px]">

                    <img
                        src="{{ asset('image/list-icon.png') }}"
                        alt=""
                        class="h-[30px] w-[30px] object-contain"
                    >

                    <div class="ml-[15px] flex flex-col">
                        <p class="text-[15px] font-medium text-white">
                            All Bookings
                        </p>

                        <p class="text-[32px] font-semibold leading-none text-white">
                            {{ $counts['all'] }}
                        </p>
                    </div>

                </div>


                {{-- STATUS --}}
                <div class="grid h-[92px] w-[1100px] grid-cols-3 rounded-lg bg-[#f5f5f5]">

                    {{-- APPROVED --}}
                    <div class="flex items-center justify-center border-r border-[#777777]">

                        <img
                            src="{{ asset('image/check-icon.png') }}"
                            alt=""
                            class="h-[30px] w-[30px] object-contain"
                        >

                        <div class="ml-[15px]">
                            <p class="text-[15px] font-medium text-[#343434]">
                                Approved
                            </p>

                            <p class="text-[32px] font-semibold leading-none text-[#343434]">
                                {{ $counts['approved'] }}
                            </p>
                        </div>

                    </div>


                    {{-- REJECTED --}}
                    <div class="flex items-center justify-center border-r border-[#777777]">

                        <img
                            src="{{ asset('image/x-icon.png') }}"
                            alt=""
                            class="h-[30px] w-[30px] object-contain"
                        >

                        <div class="ml-[15px]">
                            <p class="text-[15px] font-medium text-[#343434]">
                                Rejected
                            </p>

                            <p class="text-[32px] font-semibold leading-none text-[#343434]">
                                {{ $counts['rejected'] }}
                            </p>
                        </div>

                    </div>


                    {{-- CANCELLED --}}
                    <div class="flex items-center justify-center">

                        <img
                            src="{{ asset('image/minus-circle-icon.png') }}"
                            alt=""
                            class="h-[30px] w-[30px] object-contain"
                        >

                        <div class="ml-[15px]">
                            <p class="text-[15px] font-medium text-[#343434]">
                                Cancelled
                            </p>

                            <p class="text-[32px] font-semibold leading-none text-[#343434]">
                                {{ $counts['cancelled'] }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            @include('layouts.partials.filter-bar')


            {{-- ================= HISTORY CARDS ================= --}}
            <div class="mt-[20px] flex w-full flex-col gap-[15px] pt-[30px]">

                @forelse ($historyCards as $history)

                    <article class="flex min-h-[156px] w-full items-center rounded-lg bg-[#f5f5f5] px-[12px] py-[14px]">

                        {{-- IMAGE --}}
                        <div class="h-[128px] w-[173px] shrink-0 overflow-hidden rounded-lg bg-white">
                            <img
                                src="{{ asset('image/transparan.png') }}"
                                alt="{{ $history['facility_name'] }}"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        {{-- HISTORY INFORMATION --}}
                        <div class="ml-[28px] flex flex-1 flex-col">

                            {{-- FACILITY NAME --}}
                            <h3 class="text-[18px] font-semibold text-[#202020]">
                                {{ $history['facility_name'] }}
                            </h3>

                            {{-- DATE --}}
                            <div class="mt-[7px] flex items-center gap-[7px]">
                                <img
                                    src="{{ asset('image/calendar-icon.png') }}"
                                    alt=""
                                    class="h-[15px] w-[15px] object-contain"
                                >

                                <span class="text-[12px] text-[#555555]">
                                    {{ $history['date'] }}
                                </span>
                            </div>

                            {{-- TIME --}}
                            <div class="mt-[4px] flex items-center gap-[7px]">
                                <img
                                    src="{{ asset('image/clock-icon.png') }}"
                                    alt=""
                                    class="h-[15px] w-[15px] object-contain"
                                >

                                <span class="text-[12px] text-[#555555]">
                                    {{ $history['start_time'] }} - {{ $history['end_time'] }}
                                </span>
                            </div>

                            {{-- FLOOR --}}
                            <div class="mt-[4px] flex items-center gap-[7px]">
                                <img
                                    src="{{ asset('image/location-icon.png') }}"
                                    alt=""
                                    class="h-[15px] w-[15px] object-contain"
                                >

                                <span class="text-[12px] text-[#555555]">
                                    {{ $history['floor'] }}
                                </span>
                            </div>

                            {{-- PURPOSE --}}
                            <div class="mt-[4px] flex items-center gap-[7px]">
                                <img
                                    src="{{ asset('image/edit-icon.png') }}"
                                    alt=""
                                    class="h-[15px] w-[15px] object-contain"
                                >

                                <span class="text-[12px] text-[#555555]">
                                    {{ $history['purpose'] }}
                                </span>
                            </div>

                        </div>

                        {{-- STATUS --}}
                        <div class="flex w-[190px] shrink-0 flex-col items-center">

                            {{-- APPROVED --}}
                            @if ($history['status'] === 'approved')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#9BDCCB]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $history['status_text'] }}
                                    </span>
                                </div>

                            {{-- REJECTED --}}
                            @elseif ($history['status'] === 'rejected')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#E6A6A6]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $history['status_text'] }}
                                    </span>
                                </div>

                            {{-- CANCELLED --}}
                            @elseif ($history['status'] === 'pending')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#F6D19B]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $history['status_text'] }}
                                    </span>
                                </div>

                            @elseif ($history['status'] === 'cancelled')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#DDDDD9]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $history['status_text'] }}
                                    </span>
                                </div>

                            @endif

                            {{-- STATUS DESCRIPTION --}}
                            <p class="mt-[9px] text-center text-[12px] text-[#555555]">
                                {{ $history['status_description'] }}
                            </p>

                        </div>

                    </article>

                @empty

                    <p class="py-10 text-center text-[16px] text-white">
                        No bookings found.
                    </p>

                @endforelse

            </div>

            {{-- ================= PAGINATION ================= --}}
            @if ($bookings->lastPage() > 1)
                <div class="mt-[15px] flex w-full items-center justify-center gap-[10px] pb-[15px]">
                    @for ($page = 1; $page <= $bookings->lastPage(); $page++)
                        <a
                            href="{{ $bookings->url($page) }}"
                            class="flex h-[32px] w-[32px] items-center justify-center rounded-md text-[13px] font-medium {{ $page === $bookings->currentPage() ? 'bg-[#639178] text-white' : 'bg-[#f5f5f5] text-[#555555]' }}"
                        >
                            {{ $page }}
                        </a>
                    @endfor
                </div>
            @else
                <div class="pb-[15px]"></div>
            @endif

        </main>


    </div>
@endsection