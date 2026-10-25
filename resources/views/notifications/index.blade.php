@extends('layouts.app')

@section('title', 'Notifications - Reservasi Fasilitas Sekolah')

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
                    class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#343434] text-lg font-semibold text-white">
                    Profile
                </a>

            </nav>

            {{-- HEADER --}}
            @include('layouts.partials.header')

        </div>


        {{-- ================= BODY ================= --}}
        <main class="w-full bg-[#343434] px-10 pb-15">

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
                        Notifications
                    </h1>

                </div>

            </section>

            {{-- ================= NOTIFICATION CARDS ================= --}}
            <div class="mt-[20px] flex w-full flex-col gap-[15px] pt-[30px]">

                @forelse ($notifications as $notification)

                    <article class="flex min-h-[156px] w-full items-center rounded-lg bg-[#f5f5f5] px-[12px] py-[14px]">

                        {{-- IMAGE --}}
                        <div class="h-[128px] w-[173px] shrink-0 overflow-hidden rounded-lg bg-white">
                            <img
                                src="{{ asset('image/transparan.png') }}"
                                alt="{{ $notification['facility_name'] }}"
                                class="h-full w-full object-cover"
                            >
                        </div>


                        {{-- NOTIFICATION INFORMATION --}}
                        <div class="ml-[28px] flex flex-1 flex-col">

                            {{-- FACILITY NAME --}}
                            <h3 class="flex items-center gap-2 text-[18px] font-semibold text-[#202020]">
                                {{ $notification['facility_name'] }}

                                @if ($notification['unread'])
                                    <span class="h-[8px] w-[8px] rounded-full bg-[#639178]" title="New"></span>
                                @endif
                            </h3>


                            {{-- DATE --}}
                            <div class="mt-[7px] flex items-center gap-[7px]">
                                <img
                                    src="{{ asset('image/calendar-icon.png') }}"
                                    alt=""
                                    class="h-[15px] w-[15px] object-contain"
                                >

                                <span class="text-[12px] text-[#555555]">
                                    {{ $notification['date'] }}
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
                                    {{ $notification['start_time'] }} -
                                    {{ $notification['end_time'] }}
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
                                    {{ $notification['floor'] }}
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
                                    {{ $notification['purpose'] }}
                                </span>
                            </div>

                        </div>


                        {{-- STATUS --}}
                        <div class="flex w-[190px] shrink-0 flex-col items-center">

                            {{-- APPROVED --}}
                            @if ($notification['status'] === 'approved')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#9BDCCB]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $notification['status_text'] }}
                                    </span>
                                </div>


                            {{-- REJECTED --}}
                            @elseif ($notification['status'] === 'rejected')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#E6A6A6]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $notification['status_text'] }}
                                    </span>
                                </div>


                            {{-- CANCELLED --}}
                            @elseif ($notification['status'] === 'cancelled')

                                <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#DDDDD9]">
                                    <span class="text-[12px] font-semibold text-[#343434]">
                                        {{ $notification['status_text'] }}
                                    </span>
                                </div>

                            @endif


                            {{-- STATUS DESCRIPTION --}}
                            <p class="mt-[9px] text-center text-[12px] text-[#555555]">
                                {{ $notification['status_description'] }}
                            </p>

                        </div>

                    </article>

                @empty

                    <p class="py-10 text-center text-[16px] text-white">
                        You have no notifications yet.
                    </p>

                @endforelse

            </div>

            {{-- ================= LOAD MORE ================= --}}
            @if ($hasMore)
                <div class="mt-[15px] w-full">

                    <a
                        href="{{ route('notifications.index', ['limit' => $nextLimit]) }}"
                        class="flex h-[45px] w-full items-center justify-center gap-[7px] rounded-md border border-[#cfcfcf] bg-[#f5f5f5] text-[20px] font-bold text-[#202020]"
                    >
                        <span>Load More</span>

                        <img
                            src="{{ asset('image/arrow-down-icon.png') }}"
                            alt=""
                            class="h-[16px] w-[16px] object-contain"
                        >
                    </a>

                </div>
            @endif

        </main>


    </div>
@endsection