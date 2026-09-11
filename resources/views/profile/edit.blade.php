@extends('layouts.app')

@section('title', 'Profile - Reservasi Fasilitas Sekolah')

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
                    class="flex h-[84px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Profile
                </a>

            </nav>

            {{-- HEADER --}}
            @include('layouts.partials.header')

        </div>


        {{-- ================= BODY ================= --}}
        <div class="flex w-full min-h-[540px] bg-[#343434] px-[40px] py-[25px] text-white">

        {{-- ================= SIDEBAR ================= --}}
        <div class="flex w-[185px] shrink-0 flex-col items-center">

            {{-- PROFILE IMAGE --}}
            <div class="h-[152px] w-[152px] overflow-hidden rounded-full bg-[#f5f5f5]">
                <img
                    src="{{ asset('image/profile-bg.png') }}"
                    alt="Profile"
                    class="h-full w-full object-cover"
                >
            </div>

            {{-- ROLE --}}
            <h3 class="mt-[8px] text-[18px] font-reguler text-[#f5f5f5]">
                Student
            </h3>


            {{-- SIDEBAR MENU --}}
            <div class="mt-[32px] flex w-full flex-col gap-[10px]">

                {{-- PERSONAL INFORMATION --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="flex h-[31px] w-full items-center gap-[10px] rounded-full bg-[#639178] px-[16px]"
                >
                    <img
                        src="{{ asset('image/profile-icon.png') }}"
                        alt=""
                        class="h-[16px] w-[16px] object-contain"
                    >

                    <span class="text-[12px] font-medium text-white">
                        Personal Information
                    </span>
                </a>


                {{-- LOG OUT --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="flex h-[31px] w-full items-center gap-[10px] px-[16px] text-left"
                    >
                        <img
                            src="{{ asset('image/logout-icon.png') }}"
                            alt=""
                            class="h-[16px] w-[16px] object-contain"
                        >

                        <span class="text-[12px] text-[#f5f5f5]">
                            Log Out
                        </span>
                    </button>
                </form>

            </div>

        </div>


        {{-- ================= PERSONAL INFORMATION ================= --}}
        <div class="ml-[44px] flex flex-1 flex-col">

            <h1 class="text-[24px] font-semibold text-[#f5f5f5]">
                Personal Information
            </h1>


            {{-- FULL NAME --}}
            <div class="mt-[17px]">
                <label class="text-[15px] text-[#f5f5f5]">
                    Full Name
                </label>

                <div class="mt-[5px] flex h-[42px] w-full items-center rounded-lg bg-[#f5f5f5] px-[16px]">
                    <span class="text-[12px] text-[#343434]">
                        {{ $user->name ?? 'Justin Sebastian' }}
                    </span>
                </div>
            </div>


            {{-- EMAIL --}}
            <div class="mt-[16px]">
                <label class="text-[15px] text-[#f5f5f5]">
                    Email
                </label>

                <div class="mt-[5px] flex h-[42px] w-full items-center rounded-lg bg-[#f5f5f5] px-[16px]">
                    <span class="text-[12px] text-[#343434]">
                        {{ $user->email ?? 'justin.033@ski.sch.id' }}
                    </span>
                </div>
            </div>


            {{-- GENDER --}}
            <div class="mt-[16px]">

                <label class="text-[15px] text-[#f5f5f5]">
                    Gender
                </label>

                <div class="mt-[8px] flex items-center gap-[35px]">

                    <label class="flex items-center gap-[5px] text-[13px]">
                        <span>Male</span>
                        <input
                            type="radio"
                            name="gender"
                            value="male"
                            class="h-[15px] w-[15px]"
                            disabled
                        >
                    </label>

                    <label class="flex items-center gap-[5px] text-[13px]">
                        <span>Female</span>
                        <input
                            type="radio"
                            name="gender"
                            value="female"
                            class="h-[15px] w-[15px]"
                            disabled
                        >
                    </label>

                </div>

            </div>


            {{-- CLASS --}}
            <div class="mt-[16px]">
                <label class="text-[15px] text-[#f5f5f5]">
                    Class
                </label>

                <div class="mt-[5px] flex h-[42px] w-full items-center rounded-lg bg-[#f5f5f5] px-[16px]">
                    <span class="text-[12px] text-[#343434]">
                        {{ $user->class ?? 'XII TKJ 3' }}
                    </span>
                </div>
            </div>


            {{-- PHONE + DATE OF BIRTH --}}
            <div class="mt-[16px] grid grid-cols-2 gap-[27px]">

                {{-- PHONE --}}
                <div>
                    <label class="text-[15px] text-[#f5f5f5]">
                        Phone Number
                    </label>

                    <div class="mt-[5px] flex h-[42px] items-center rounded-lg bg-[#f5f5f5] px-[16px]">
                        <span class="text-[12px] text-[#343434]">
                            {{ $user->phone ?? '+62 8*** **** ****' }}
                        </span>
                    </div>
                </div>


                {{-- DATE OF BIRTH --}}
                <div>
                    <label class="text-[15px] text-[#f5f5f5]">
                        Date of Birth
                    </label>

                    <div class="mt-[5px] flex h-[42px] items-center rounded-lg bg-[#f5f5f5] px-[16px]">
                        <span class="text-[12px] text-[#343434]">
                            {{ $user->date_of_birth ?? 'Day Month, Year' }}
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </div>


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