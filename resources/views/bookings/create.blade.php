@extends('layouts.app')

@section('title', 'Book ' . $facility->name . ' - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="w-full rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            <a href="{{ route('facilities.index') }}" class="mb-6 inline-flex items-center gap-2 text-[16px] font-medium text-white hover:text-[#9fbfae]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Back to Facilities
            </a>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

                {{-- ================= FACILITY SUMMARY ================= --}}
                <aside class="rounded-lg bg-white p-5 lg:col-span-2">

                    <div class="h-[200px] w-full overflow-hidden rounded-lg">
                        <img
                            src="{{ $facility->image ? asset('storage/' . $facility->image) : asset('image/transparan.png') }}"
                            alt="{{ $facility->name }}"
                            class="h-full w-full object-cover"
                        >
                    </div>

                    <span class="mt-4 inline-block rounded-full bg-[#e4ede8] px-4 py-1 text-[12px] font-semibold uppercase tracking-wide text-[#639178]">
                        {{ $facility->category }}
                    </span>

                    <h2 class="mt-3 text-[24px] font-semibold leading-tight text-[#303030]">{{ $facility->name }}</h2>

                    <div class="mt-2 flex items-center gap-2">
                        <img src="{{ asset('image/location-icon.png') }}" alt="" class="h-[22px] w-[22px] object-contain">
                        <p class="text-[15px] text-gray-500">{{ $facility->location }}</p>
                    </div>

                    @if ($facility->capacity)
                        <div class="mt-1 flex items-center gap-2">
                            <img src="{{ asset('image/building-icon.png') }}" alt="" class="h-[22px] w-[22px] object-contain">
                            <p class="text-[15px] text-gray-500">Capacity: {{ $facility->capacity }} people</p>
                        </div>
                    @endif

                    @if ($facility->description)
                        <p class="mt-4 text-[14px] leading-6 text-gray-600">{{ $facility->description }}</p>
                    @endif

                </aside>

                {{-- ================= BOOKING FORM ================= --}}
                <section class="rounded-lg bg-white p-7 lg:col-span-3">

                    <h1 class="text-[26px] font-bold text-[#303030]">Book this facility</h1>
                    <p class="mt-1 text-[15px] text-gray-500">
                        Fill in the details below. Your request will be reviewed by an admin.
                    </p>

                    @if ($facility->status !== 'active')
                        <div class="mt-5 rounded-md border border-amber-300 bg-amber-50 px-4 py-3 text-[14px] text-amber-800">
                            This facility is currently not available for booking.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-5 rounded-md border border-red-300 bg-red-50 px-4 py-3 text-[14px] text-red-600">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}" class="mt-6 flex flex-col gap-5">
                        @csrf
                        <input type="hidden" name="facility_id" value="{{ $facility->id }}">

                        <div>
                            <label for="booking_date" class="mb-1 block text-[15px] font-medium text-[#303030]">Date</label>
                            <input
                                id="booking_date"
                                name="booking_date"
                                type="date"
                                min="{{ now()->toDateString() }}"
                                value="{{ old('booking_date') }}"
                                required
                                class="h-[48px] w-full rounded-md border border-gray-300 px-4 text-[15px] text-[#303030] outline-none focus:border-[#639178]"
                            >
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="start_time" class="mb-1 block text-[15px] font-medium text-[#303030]">Start time</label>
                                <input
                                    id="start_time"
                                    name="start_time"
                                    type="time"
                                    value="{{ old('start_time') }}"
                                    required
                                    class="h-[48px] w-full rounded-md border border-gray-300 px-4 text-[15px] text-[#303030] outline-none focus:border-[#639178]"
                                >
                            </div>

                            <div>
                                <label for="end_time" class="mb-1 block text-[15px] font-medium text-[#303030]">End time</label>
                                <input
                                    id="end_time"
                                    name="end_time"
                                    type="time"
                                    value="{{ old('end_time') }}"
                                    required
                                    class="h-[48px] w-full rounded-md border border-gray-300 px-4 text-[15px] text-[#303030] outline-none focus:border-[#639178]"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="purpose" class="mb-1 block text-[15px] font-medium text-[#303030]">Purpose</label>
                            <input
                                id="purpose"
                                name="purpose"
                                type="text"
                                maxlength="255"
                                value="{{ old('purpose') }}"
                                placeholder="e.g. Worship rehearsal"
                                required
                                class="h-[48px] w-full rounded-md border border-gray-300 px-4 text-[15px] text-[#303030] outline-none focus:border-[#639178]"
                            >
                        </div>

                        <div class="mt-2 flex flex-col gap-3 sm:flex-row">
                            <button
                                type="submit"
                                {{ $facility->status !== 'active' ? 'disabled' : '' }}
                                class="h-[50px] flex-1 rounded-md bg-[#639178] text-[16px] font-semibold text-white transition hover:bg-[#527d66] disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                Submit Request
                            </button>

                            <a
                                href="{{ route('facilities.index') }}"
                                class="flex h-[50px] items-center justify-center rounded-md border border-gray-300 px-8 text-[16px] font-semibold text-[#303030] transition hover:bg-gray-50"
                            >
                                Cancel
                            </a>
                        </div>

                    </form>

                </section>

            </div>

        </main>

    </div>

@endsection
