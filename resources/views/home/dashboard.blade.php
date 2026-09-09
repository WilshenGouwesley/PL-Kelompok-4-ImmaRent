@extends('layouts.app')

@section('title', 'DashboardHome - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        {{-- ================= HEADER + NAVIGATION ================= --}}
        <div class="flex w-full items-end justify-between pt-4">

            {{-- NAVIGATION --}}
            <nav class="flex items-end gap-1">

                {{-- HOME --}}
                <a href="{{ route('home') }}"
                    class="flex h-[84px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Home
                </a>


                {{-- FACILITIES --}}
                <a href="{{ route('facilities.index') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Facilities
                </a>


                {{-- BOOKINGS --}}
                <a href="{{ route('bookings.index') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
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
        <main class="w-full bg-[#343434] px-10 pb-35">

            {{-- ================= HERO ================= --}}
            <section class="
                flex
                w-full
                items-start
                justify-between
                pt-[35px]
            ">

                {{-- TEXT --}}
                <div class="w-1/2">

                    <h1 class="
                            text-[38px]
                            font-semibold
                            leading-[1.1]
                            text-white
                        ">
                        Hello, Justin!
                    </h1>


                    <p class="
                            mt-4
                            max-w-[480px]
                            text-[19px]
                            leading-5
                            text-white
                        ">
                        Welcome to the School Facility Booking System
                    </p>

                </div>

            </section>

            {{-- ================= SUMMARY CARDS ================= --}}
            <div class="grid w-full pt-[35px] pb-[35px] grid-cols-3 gap-[67px]">

                {{-- CARD 1 --}}
                <div class="flex h-[128px] items-center rounded-lg bg-[#f5f5f5] px-6">

                    <img
                        src="{{ asset('image/book-icon.png') }}"
                        alt=""
                        class="h-[48px] w-[48px] object-contain"
                    >

                    <div class="ml-8">
                        <p class="text-[19px] font-semibold text-[#343434]">
                            Active Loans
                        </p>

                        <p class="text-[42px] font-medium leading-none text-[#343434]">
                            2
                        </p>

                        <p class="mt-1 text-[15px] text-[#343434]">
                            Ongoing
                        </p>
                    </div>

                </div>


                {{-- CARD 2 --}}
                <div class="flex h-[128px] items-center rounded-lg bg-[#f5f5f5] px-6">

                    <img
                        src="{{ asset('image/checklist-icon.png') }}"
                        alt=""
                        class="h-[48px] w-[48px] object-contain"
                    >

                    <div class="ml-8">
                        <p class="text-[19px] font-semibold text-[#343434]">
                            Requests Approved
                        </p>

                        <p class="text-[42px] font-medium leading-none text-[#343434]">
                            1
                        </p>

                        <p class="mt-1 text-[15px] text-[#343434]">
                            This Month
                        </p>
                    </div>

                </div>


                {{-- CARD 3 --}}
                <div class="flex h-[128px] items-center rounded-lg bg-[#f5f5f5] px-6">

                    <img
                        src="{{ asset('image/clock-icon.png') }}"
                        alt=""
                        class="h-[48px] w-[48px] object-contain"
                    >

                    <div class="ml-8">
                        <p class="text-[19px] font-semibold text-[#343434]">
                            Pending Approval
                        </p>

                        <p class="text-[42px] font-medium leading-none text-[#343434]">
                            3
                        </p>

                        <p class="mt-1 text-[15px] text-[#343434]">
                            Required
                        </p>
                    </div>

                </div>

            </div>


            {{-- ================= FEATURED FACILITIES ================= --}}
            <section class="
            relative
            w-full
            rounded-lg
            bg-white
            px-7
            py-6
            ">

                {{-- TITLE --}}
                <h2 class="text-[35px] font-semibold text-black">
                    Featured Facilities
                </h2>


                {{-- ================= CAROUSEL ================= --}}
                <div class="relative mt-8 w-full">

                    {{-- VIEWPORT --}}
                    <div id="facility-carousel" class="w-full overflow-hidden">

                        {{-- TRACK --}}
                        <div
                            id="facility-track"
                            class="flex gap-6 transition-transform duration-500 ease-in-out"
                        >

                            @foreach ($featuredFacilities as $facility)

                                <article
                                    class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0"
                                >

                                    {{-- IMAGE --}}
                                    <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                        <img
                                            src="{{ asset($facility['image']) }}"
                                            alt="{{ $facility['name'] }}"
                                            class="h-full w-full object-cover"
                                        >
                                    </div>

                                    {{-- NAME --}}
                                    <div class="mt-3 flex items-center gap-2">

                                        <img
                                            src="{{ asset('image/building-icon.png') }}"
                                            alt=""
                                            class="h-[30px] w-[30px] object-contain"
                                        >

                                        <p class="text-[18px] font-semibold text-[#343434]">
                                            {{ $facility['name'] }}
                                        </p>

                                    </div>

                                    {{-- LOCATION --}}
                                    <div class="mt-1 flex items-center gap-2">

                                        <img
                                            src="{{ asset('image/location-icon.png') }}"
                                            alt=""
                                            class="h-[28px] w-[28px] object-contain"
                                        >

                                        <p class="text-[15px] text-gray-500">
                                            {{ $facility['location'] }}
                                        </p>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </div>


                    {{-- ================= LEFT BUTTON ================= --}}
                    <button id="facility-prev" type="button" aria-label="Previous" class="
                    absolute
                    -left-[48px]
                    top-[58px]
                    z-10
                    flex
                    h-[48px]
                    w-[48px]
                    items-center
                    justify-center
                    border-0
                    bg-transparent
                    p-0
                    transition
                    duration-200
                    hover:scale-110
                ">
                        <img src="{{ asset('image/left-button.png') }}" alt="Previous"
                            class="h-[48px] w-[48px] object-contain">
                    </button>


                    {{-- ================= RIGHT BUTTON ================= --}}
                    <button id="facility-next" type="button" aria-label="Next" class="
                    absolute
                    -right-[48px]
                    top-[58px]
                    z-10
                    flex
                    h-[48px]
                    w-[48px]
                    items-center
                    justify-center
                    border-0
                    bg-transparent
                    p-0
                    transition
                    duration-200
                    hover:scale-110
                ">
                        <img src="{{ asset('image/right-button.png') }}" alt="Next"
                            class="h-[48px] w-[48px] object-contain">
                    </button>

                </div>

            </section>

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