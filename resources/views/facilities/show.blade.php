@extends('layouts.app')

@section('title', $facility->name . ' - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="w-full rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            <a href="{{ route('facilities.index') }}" class="mb-6 inline-flex items-center gap-2 text-[16px] font-medium text-white hover:text-[#9fbfae]">
                <img src="{{ asset('image/left-button.png') }}" alt="Back">
                Back to Facilities
            </a>

            <section class="grid grid-cols-1 gap-8 rounded-lg bg-white p-7 md:grid-cols-2">

                <div class="h-[260px] w-full overflow-hidden rounded-lg md:h-[340px]">
                    <img
                        src="{{ $facility->image ? asset('storage/' . $facility->image) : asset('image/transparan.png') }}"
                        alt="{{ $facility->name }}"
                        class="h-full w-full object-cover"
                    >
                </div>

                <div class="flex flex-col justify-between">

                    <div>
                        <span class="inline-block rounded-full bg-[#e4ede8] px-4 py-1 text-[13px] font-semibold uppercase tracking-wide text-[#639178]">
                            {{ $facility->category }}
                        </span>

                        <h1 class="mt-4 text-[30px] font-semibold leading-tight text-[#303030] md:text-[34px]">
                            {{ $facility->name }}
                        </h1>

                        <div class="mt-3 flex items-center gap-2">
                            <img src="{{ asset('image/location-icon.png') }}" alt="" class="h-[24px] w-[24px] object-contain">
                            <p class="text-[16px] text-gray-500">{{ $facility->location }}</p>
                        </div>

                        @if ($facility->capacity)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ asset('image/building-icon.png') }}" alt="" class="h-[24px] w-[24px] object-contain">
                                <p class="text-[16px] text-gray-500">Capacity: {{ $facility->capacity }} people</p>
                            </div>
                        @endif

                        <p class="mt-5 text-[15px] leading-6 text-gray-600">
                            {{ $facility->description ?? 'No description has been added for this facility yet.' }}
                        </p>
                    </div>

                    <div class="mt-8">
                        @auth
                            <a
                                href="{{ route('bookings.create', $facility) }}"
                                class="flex h-[56px] w-full items-center justify-center rounded-md bg-[#639178] text-[18px] font-semibold text-white transition duration-200 hover:bg-[#527d66] md:w-[240px]"
                            >
                                Book this facility
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="flex h-[56px] w-full items-center justify-center rounded-md bg-[#639178] text-[18px] font-semibold text-white transition duration-200 hover:bg-[#527d66] md:w-[240px]"
                            >
                                Login to book
                            </a>
                        @endauth
                    </div>

                </div>

            </section>

        </main>

    </div>

@endsection
