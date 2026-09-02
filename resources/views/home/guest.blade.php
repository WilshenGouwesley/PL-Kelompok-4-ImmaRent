@extends('layouts.app')

@section('title', 'Beranda - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        {{-- ================= HEADER + NAVIGATION ================= --}}
        <div class="flex w-full items-end justify-between pt-4">

            {{-- NAVIGATION --}}
            <nav class="flex items-end gap-1">

                {{-- HOME --}}
                <a href="{{ route('home') }}"
                    class="flex h-[84px] w-[190px] items-center justify-center rounded-t-lg bg-[#303030] text-lg font-semibold text-white">
                    Home
                </a>


                {{-- FACILITIES --}}
                <a href="{{ route('facilities.index') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#303030] text-lg font-semibold text-white">
                    Facilities
                </a>


                {{-- LOGIN --}}
                <a href="{{ route('login') }}"
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#303030] text-lg font-semibold text-white">
                    Login
                </a>

            </nav>

            {{-- HEADER --}}
            @include('layouts.partials.header')

        </div>


        {{-- ================= BODY ================= --}}
        <main class="w-full bg-[#303030] px-10 pb-10 pt-[35px]">

            {{-- ================= HERO ================= --}}
            <section class="
                    flex min-h-[320px] w-full
                    items-center justify-between
                ">

                {{-- TEXT --}}
                <div class="w-1/2">

                    <h1 class="
                            text-[68px]
                            font-medium
                            leading-[1.1]
                            text-white
                        ">
                        Big ideas need the<br>
                        right space.
                    </h1>


                    <p class="
                            mt-4
                            max-w-[480px]
                            text-[18px]
                            leading-5
                            text-white
                        ">
                        Explore our school facilities, choose the perfect
                        one for your plans, and reserve it effortlessly.
                    </p>


                    <a href="{{ route('login') }}" class="
                            mt-7
                            mb-7
                            flex h-[60px] w-[177px]
                            items-center justify-center
                            rounded-md
                            bg-[#639178]
                            text-[25px]
                            font-semibold
                            text-white
                            transition
                            duration-200
                            hover:bg-[#527d66]
                        ">
                        Login
                    </a>

                </div>


                {{-- GAMBAR SEKOLAH --}}
                <div class="
                        flex w-1/2
                        items-center
                        justify-end
                    ">

                    <img src="{{ asset('image/building-picture.png') }}" alt="School Building"
                        class="w-[570px] max-w-full object-contain">

                </div>

            </section>


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
                        <div id="facility-track" class="flex gap-6 transition-transform duration-500 ease-in-out">

                            {{-- ================= CARD 1 ================= --}}
                            <article
                                class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0">

                                {{-- IMAGE --}}
                                <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                    <img src="{{ asset('image/transparan.png') }}" alt="Computer Laboratory"
                                        class="h-full w-full object-cover">
                                </div>

                                {{-- NAME --}}
                                <div class="mt-3 flex items-center gap-2">

                                    <img src="{{ asset('image/building-icon.png') }}" alt=""
                                        class="h-[30px] w-[30px] object-contain">

                                    <p class="text-[18px] font-semibold text-[#303030]">
                                        Computer Laboratory
                                    </p>

                                </div>

                                {{-- LOCATION --}}
                                <div class="mt-1 flex items-center gap-2">

                                    <img src="{{ asset('image/location-icon.png') }}" alt=""
                                        class="h-[28px] w-[28px] object-contain">

                                    <p class="text-[15px] text-gray-500">
                                        IELTS Centre
                                    </p>

                                </div>

                            </article>


                            {{-- ================= CARD 2 ================= --}}
                            <article
                                class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0">

                                <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                    <img src="{{ asset('image/transparan.png') }}" alt="Computer Laboratory"
                                        class="h-full w-full object-cover">
                                </div>

                                <div class="mt-3 flex items-center gap-2">

                                    <img src="{{ asset('image/building-icon.png') }}" alt=""
                                        class="h-[30px] w-[30px] object-contain">

                                    <p class="text-[18px] font-semibold text-[#303030]">
                                        Computer Laboratory
                                    </p>

                                </div>

                                <div class="mt-1 flex items-center gap-2">

                                    <img src="{{ asset('image/location-icon.png') }}" alt=""
                                        class="h-[28px] w-[28px] object-contain">

                                    <p class="text-[15px] text-gray-500">
                                        IELTS Centre
                                    </p>

                                </div>

                            </article>


                            {{-- ================= CARD 3 ================= --}}
                            <article
                                class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0">

                                <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                    <img src="{{ asset('image/transparan.png') }}" alt="Computer Laboratory"
                                        class="h-full w-full object-cover">
                                </div>

                                <div class="mt-3 flex items-center gap-2">

                                    <img src="{{ asset('image/building-icon.png') }}" alt=""
                                        class="h-[30px] w-[30px] object-contain">

                                    <p class="text-[18px] font-semibold text-[#303030]">
                                        Computer Laboratory
                                    </p>

                                </div>

                                <div class="mt-1 flex items-center gap-2">

                                    <img src="{{ asset('image/location-icon.png') }}" alt=""
                                        class="h-[28px] w-[28px] object-contain">

                                    <p class="text-[15px] text-gray-500">
                                        IELTS Centre
                                    </p>

                                </div>

                            </article>


                            {{-- ================= CARD 4 ================= --}}
                            <article
                                class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0">

                                <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                    <img src="{{ asset('image/transparan.png') }}" alt="Computer Laboratory"
                                        class="h-full w-full object-cover">
                                </div>

                                <div class="mt-3 flex items-center gap-2">

                                    <img src="{{ asset('image/building-icon.png') }}" alt=""
                                        class="h-[30px] w-[30px] object-contain">

                                    <p class="text-[18px] font-semibold text-[#303030]">
                                        Computer Laboratory
                                    </p>

                                </div>

                                <div class="mt-1 flex items-center gap-2">

                                    <img src="{{ asset('image/location-icon.png') }}" alt=""
                                        class="h-[28px] w-[28px] object-contain">

                                    <p class="text-[15px] text-gray-500">
                                        IELTS Centre
                                    </p>

                                </div>

                            </article>


                            {{-- ================= CARD 5 ================= --}}
                            <article
                                class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0">

                                <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                    <img src="{{ asset('image/transparan.png') }}" alt="Computer Laboratory"
                                        class="h-full w-full object-cover">
                                </div>

                                <div class="mt-3 flex items-center gap-2">

                                    <img src="{{ asset('image/building-icon.png') }}" alt=""
                                        class="h-[30px] w-[30px] object-contain">

                                    <p class="text-[18px] font-semibold text-[#303030]">
                                        Computer Laboratory
                                    </p>

                                </div>

                                <div class="mt-1 flex items-center gap-2">

                                    <img src="{{ asset('image/location-icon.png') }}" alt=""
                                        class="h-[28px] w-[28px] object-contain">

                                    <p class="text-[15px] text-gray-500">
                                        IELTS Centre
                                    </p>

                                </div>

                            </article>


                            {{-- ================= CARD 6 ================= --}}
                            <article
                                class="facility-card w-[calc((100%-72px)/4)] min-w-[calc((100%-72px)/4)] flex-shrink-0">

                                <div class="h-[145px] w-full overflow-hidden rounded-lg">
                                    <img src="{{ asset('image/transparan.png') }}" alt="Computer Laboratory"
                                        class="h-full w-full object-cover">
                                </div>

                                <div class="mt-3 flex items-center gap-2">

                                    <img src="{{ asset('image/building-icon.png') }}" alt=""
                                        class="h-[30px] w-[30px] object-contain">

                                    <p class="text-[18px] font-semibold text-[#303030]">
                                        Computer Laboratory
                                    </p>

                                </div>

                                <div class="mt-1 flex items-center gap-2">

                                    <img src="{{ asset('image/location-icon.png') }}" alt=""
                                        class="h-[28px] w-[28px] object-contain">

                                    <p class="text-[15px] text-gray-500">
                                        IELTS Centre
                                    </p>

                                </div>

                            </article>

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