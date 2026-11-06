@extends('layouts.app')

@section('title', 'Bookings - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        {{-- ================= HEADER + NAVIGATION ================= --}}
        <div class="flex w-full items-end justify-between pt-4">

            @include('layouts.partials.navbar', ['tabBg' => 'bg-[#343434]'])

            {{-- HEADER --}}
            @include('layouts.partials.header')

        </div>


        {{-- ================= BODY ================= --}}
        <main class="w-full bg-[#343434] px-10 pb-10">

            @include('layouts.partials.filter-search')

            @include('layouts.partials.filter-bar')


            {{-- ================= BOOKING CARDS ================= --}}
<div class="mt-[20px] flex w-full flex-col gap-[15px]">

    @forelse ($bookings as $booking)

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

                @elseif ($booking['status'] === 'rejected')

                    <div class="flex h-[29px] w-[130px] items-center justify-center rounded-full bg-[#F9B4B4]">
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
                    href="{{ route('bookings.show', $booking['id']) }}"
                    class="mt-[15px] flex h-[30px] w-[130px] items-center justify-center rounded border border-[#639178] text-[12px] font-medium text-[#343434]"
                >
                    View Details
                </a>

            </div>

        </article>

    @empty

        <p class="py-10 text-center text-[16px] text-white">
            You have no bookings yet.
            <a href="{{ route('facilities.index') }}" class="font-semibold underline">Browse facilities</a>
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
            @endif

        </main>


    </div>
@endsection