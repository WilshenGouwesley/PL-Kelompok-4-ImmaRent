@extends('layouts.app')

@section('title', 'Bookings - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        {{-- ================= HEADER + NAVIGATION ================= --}}
        <div class="flex w-full items-end justify-between pt-4">

            {{-- NAVIGATION --}}
            <nav class="flex items-end gap-1">

                {{-- HOME --}}
                <a href="{{ route('home') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Home
                </a>


                {{-- FACILITIES --}}
                <a href="{{ route('facilities.index') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Facilities
                </a>


                {{-- BOOKINGS --}}
                <a href="{{ route('bookings.index') }}"
                    class="flex h-[84px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Bookings
                </a>

                {{-- HISTORY --}}
                <a href="{{ route('history.index') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    History
                </a>    

                {{-- PROFILE --}}
                <a href="{{ route('profile.edit') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Profile
                </a>

            </nav>

            {{-- HEADER --}}
            @include('layouts.partials.header')

        </div>


        {{-- ================= BODY ================= --}}
        <main class="w-full bg-[#343434] px-10 pb-10">

            {{-- ================= HERO ================= --}}
            <section class="
                flex
                w-full
                items-start
                justify-between
                pt-[35px]
            ">
                <div class="flex h-[50px] w-full items-center rounded-lg bg-white px-[15px]">

                    {{-- Tulisan Search di kiri --}}
                    <span class="text-[14px] text-gray-400">
                        Search...
                    </span>

                    {{-- Icon Search di kanan --}}
                    <img
                        src="{{ asset('image/search-icon.png') }}"
                        alt="Search"
                        class="ml-auto h-[22px] w-[22px] object-contain"
                    >

                </div>
            </section>

            {{-- ================= FILTER ================= --}}
            <div class="flex w-full items-center justify-between pt-[15px]">

                {{-- FILTER LEFT --}}
                <div class="flex items-center gap-[15px]">

                    <p class="text-[15px] font-reguler text-white">
                        Filter by:
                    </p>

                    {{-- DATE --}}
                    <div class="flex h-[26px] w-[82px] items-center justify-between rounded-full bg-[#f5f5f5] px-[14px]">
                        <span class="text-[15px] text-[#343434]">
                            Date
                        </span>

                        <img
                            src="{{ asset('image/arrow-down-icon.png') }}"
                            alt=""
                            class="h-[15px] w-[15px] object-contain"
                        >
                    </div>

                    {{-- CATEGORY --}}
                    <div class="flex h-[26px] w-[110px] items-center justify-between rounded-full bg-[#f5f5f5] px-[14px]">
                        <span class="text-[15px] text-[#343434]">
                            Category
                        </span>

                        <img
                            src="{{ asset('image/arrow-down-icon.png') }}"
                            alt=""
                            class="h-[15px] w-[15px] object-contain"
                        >
                    </div>

                    {{-- STATUS --}}
                    <div class="flex h-[26px] w-[92px] items-center justify-between rounded-full bg-[#f5f5f5] px-[14px]">
                        <span class="text-[15px] text-[#343434]">
                            Status
                        </span>

                        <img
                            src="{{ asset('image/arrow-down-icon.png') }}"
                            alt=""
                            class="h-[15px] w-[15px] object-contain"
                        >
                    </div>

                </div>


                {{-- RESET FILTER --}}
                <div class="flex h-[35px] w-[140px] items-center justify-center gap-[7px] rounded-sm bg-[#639178]">

                    <img
                        src="{{ asset('image/refresh-icon.png') }}" 
                        class="h-[20px] w-[20px]"
                    >

                    </img>

                    <span class="text-[15px] font-reguler text-white">
                        Reset Filter
                    </span>

                </div>

            </div>


            {{-- ================= BOOKING CARDS ================= --}}
<div class="mt-[20px] flex w-full flex-col gap-[15px]">

    @foreach ($bookings as $booking)

        <article class="flex min-h-[156px] w-full items-center rounded-lg bg-[#f5f5f5] px-[12px] py-[14px]">

            {{-- ================= IMAGE ================= --}}
            <div class="h-[128px] w-[173px] shrink-0 overflow-hidden rounded-lg bg-white">

                <img
                    src="{{ asset('image/transparan.png') }}"
                    alt="{{ $booking['facility_name'] }}"
                    class="h-full w-full object-cover"
                >

            </div>


            {{-- ================= BOOKING INFORMATION ================= --}}
            <div class="ml-[28px] flex flex-1 flex-col">

                {{-- FACILITY NAME --}}
                <h3 class="text-[18px] font-semibold text-[#202020]">
                    {{ $booking['facility_name'] }}
                </h3>


                {{-- DATE --}}
                <div class="mt-[7px] flex items-center gap-[7px]">

                    <img
                        src="{{ asset('image/calendar-icon.png') }}"
                        alt=""
                        class="h-[15px] w-[15px] object-contain"
                    >

                    <span class="text-[12px] text-[#555555]">
                        {{ $booking['date'] }}
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
                        {{ $booking['start_time'] }} - {{ $booking['end_time'] }}
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
                        {{ $booking['floor'] }}
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
                        {{ $booking['purpose'] }}
                    </span>

                </div>

            </div>


            {{-- ================= STATUS ================= --}}
            <div class="flex w-[190px] shrink-0 flex-col items-center">

                @if ($booking['status'] === 'approved')

                    <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#9BDCCB]">
                        <span class="text-[12px] font-semibold text-[#343434]">
                            {{ $booking['status_text'] }}
                        </span>
                    </div>

                @elseif ($booking['status'] === 'pending')

                    <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#F6D19B]">
                        <span class="text-[12px] font-semibold text-[#343434]">
                            {{ $booking['status_text'] }}
                        </span>
                    </div>

                @elseif ($booking['status'] === 'cancelled')

                    <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#DDDDD9]">
                        <span class="text-[12px] font-semibold text-[#343434]">
                            {{ $booking['status_text'] }}
                        </span>
                    </div>

                @endif


                {{-- STATUS DESCRIPTION --}}
                <p class="mt-[9px] text-center text-[12px] text-[#555555]">
                    {{ $booking['status_description'] }}
                </p>


                {{-- VIEW DETAILS --}}
                <a
                    href="#"
                    class="mt-[15px] flex h-[30px] w-[130px] items-center justify-center rounded border border-[#639178] text-[12px] font-medium text-[#343434]"
                >
                    View Details
                </a>

            </div>

        </article>

    @endforeach

</div>

        </main>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const track = document.getElementById('facility-track');
            const prevButton = document.getElementById('facility-prev');
            const nextButton = document.getElementById('facility-next');

            const cards = track.querySelectorAll('.facility-card');

            let currentIndex = 0;

            const visibleCards = 4;
            const gap = 24;


            function updateCarousel() {

                const cardWidth = cards[0].offsetWidth;

                const moveDistance = cardWidth + gap;

                track.style.transform =
                    `translateX(-${currentIndex * moveDistance}px)`;


                // Tombol kiri
                if (currentIndex === 0) {

                    prevButton.style.opacity = '0.5';
                    prevButton.style.pointerEvents = 'none';

                } else {

                    prevButton.style.opacity = '1';
                    prevButton.style.pointerEvents = 'auto';

                }


                // Tombol kanan
                if (currentIndex >= cards.length - visibleCards) {

                    nextButton.style.opacity = '0.5';
                    nextButton.style.pointerEvents = 'none';

                } else {

                    nextButton.style.opacity = '1';
                    nextButton.style.pointerEvents = 'auto';

                }

            }


            // ================= NEXT =================

            nextButton.addEventListener('click', function () {

                if (currentIndex < cards.length - visibleCards) {

                    currentIndex++;

                    updateCarousel();

                }

            });


            // ================= PREVIOUS =================

            prevButton.addEventListener('click', function () {

                if (currentIndex > 0) {

                    currentIndex--;

                    updateCarousel();

                }

            });


            // Update ketika ukuran layar berubah

            window.addEventListener('resize', function () {

                updateCarousel();

            });


            updateCarousel();

        });
    </script>
@endsection