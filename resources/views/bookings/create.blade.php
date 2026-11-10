@extends('layouts.app')

@section('title', 'Book ' . $facility->name . ' - Reservasi Fasilitas Sekolah')

@section('content')

    @php
        $me = auth()->user();
        $selectedClass = old('class', in_array($me->class, $classes, true) ? $me->class : null);
        $isActive = $facility->status === 'active';

        $field = 'h-[58px] w-full rounded-2xl bg-white px-6 text-[17px] text-[#343434] outline-none placeholder:text-gray-400';
        $timeSelect = 'h-[58px] w-full appearance-none rounded-2xl bg-white pl-[56px] pr-12 text-[17px] text-gray-400 outline-none valid:pt-4 valid:font-semibold valid:text-[#343434] disabled:cursor-not-allowed disabled:opacity-60';
    @endphp

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar', ['tabBg' => 'bg-[#343434]'])
            @include('layouts.partials.header')
        </div>

        <main class="w-full rounded-b-lg bg-[#343434] px-10 pb-14 pt-10">

            <form
                id="booking-form"
                method="POST"
                action="{{ route('bookings.store') }}"
                data-booking-calendar
                data-busy="{{ json_encode($busy) }}"
                data-today="{{ $today }}"
                data-now="{{ $nowTime }}"
                data-initial-date="{{ old('booking_date') }}"
                class="grid grid-cols-1 gap-12 lg:grid-cols-[minmax(0,1fr)_1px_minmax(0,1fr)]"
            >
                @csrf
                <input type="hidden" name="facility_id" value="{{ $facility->id }}">

                {{-- ================= KIRI: KALENDER + JAM ================= --}}
                <section class="animate-fade-up text-white">

                    <div class="flex items-center justify-between">
                        <h2 data-cal-title class="text-[34px] font-bold leading-none">{{ now()->format('F Y') }}</h2>

                        <div class="flex gap-3">
                            <button type="button" data-cal-prev aria-label="Previous month"
                                class="flex h-[38px] w-[38px] items-center justify-center rounded-full border border-white/60 text-white hover:bg-white/10 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-transparent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[16px] w-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6" /></svg>
                            </button>
                            <button type="button" data-cal-next aria-label="Next month"
                                class="flex h-[38px] w-[38px] items-center justify-center rounded-full border border-white/60 text-white hover:bg-white/10 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-transparent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[16px] w-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-7 text-center text-[14px] font-semibold tracking-wide">
                        @foreach (['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'] as $weekday)
                            <span>{{ $weekday }}</span>
                        @endforeach
                    </div>

                    {{-- diisi oleh booking-calendar.js --}}
                    <div data-cal-grid class="mt-4 grid grid-cols-7 gap-y-2 text-center"></div>

                    {{-- tanggal terpilih; kalau JavaScript mati, kolom tanggal biasa di bawah dipakai (nilai terakhir menang) --}}
                    <input type="hidden" name="booking_date" data-cal-input value="{{ old('booking_date') }}">
                    <noscript>
                        <input type="date" name="booking_date" min="{{ $today }}" value="{{ old('booking_date') }}" class="{{ $field }} mt-6 block">
                    </noscript>

                    <div class="mt-8 flex h-[58px] items-center gap-3 rounded-2xl bg-white px-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[22px] w-[22px] shrink-0 text-[#343434]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2" /><path d="M3 9h18M8 2v4M16 2v4" /></svg>
                        <input type="text" readonly data-cal-display placeholder="Select a day" aria-label="Selected day"
                            class="w-full bg-transparent text-[17px] text-[#343434] outline-none placeholder:text-gray-400">
                    </div>

                    <p data-cal-error role="alert" class="mt-2 min-h-[20px] text-[14px] text-red-300"></p>

                    <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- JAM MULAI --}}
                        <div class="group relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-5 top-1/2 h-[22px] w-[22px] -translate-y-1/2 text-[#343434]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 3" /></svg>
                            <span class="pointer-events-none absolute left-[56px] top-[9px] text-[12px] text-gray-500 opacity-0 transition-opacity group-has-[select:valid]:opacity-100">Start with</span>
                            <select id="start_time" name="start_time" required aria-label="Start time" class="{{ $timeSelect }}">
                                <option value="" disabled hidden @selected(! old('start_time'))>Start with</option>
                                @foreach ($startSlots as $slot)
                                    <option value="{{ $slot['value'] }}" @selected(old('start_time') === $slot['value'])>{{ $slot['label'] }}</option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-5 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#343434]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9" /></svg>
                        </div>

                        {{-- JAM SELESAI --}}
                        <div class="group relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-5 top-1/2 h-[22px] w-[22px] -translate-y-1/2 text-[#343434]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 3" /></svg>
                            <span class="pointer-events-none absolute left-[56px] top-[9px] text-[12px] text-gray-500 opacity-0 transition-opacity group-has-[select:valid]:opacity-100">End with</span>
                            <select id="end_time" name="end_time" required aria-label="End time" class="{{ $timeSelect }}">
                                <option value="" disabled hidden @selected(! old('end_time'))>End with</option>
                                @foreach ($endSlots as $slot)
                                    <option value="{{ $slot['value'] }}" @selected(old('end_time') === $slot['value'])>{{ $slot['label'] }}</option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-5 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#343434]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9" /></svg>
                        </div>

                    </div>

                    <p data-busy-note class="mt-4 min-h-[22px] text-[14px] text-white/60"></p>

                </section>

                {{-- pemisah --}}
                <div class="hidden bg-white/25 lg:block"></div>

                {{-- ================= KANAN: INFORMASI BOOKING ================= --}}
                <section class="flex animate-fade-up flex-col text-white [animation-delay:120ms]">

                    <h1 class="text-[28px] font-bold leading-tight">Booking Information</h1>
                    <p class="mt-1 text-[15px] text-white/80">Please fill in the details below.</p>

                    {{-- fasilitas yang sedang dibooking --}}
                    <p class="mt-4 inline-flex w-fit flex-wrap items-center gap-x-2 rounded-full bg-white/10 px-4 py-1.5 text-[14px]">
                        <span class="font-semibold">{{ $facility->name }}</span>
                        <span class="text-white/40" aria-hidden="true">&bull;</span>
                        <span class="text-white/70">{{ $facility->location }}</span>
                    </p>

                    @unless ($isActive)
                        <div class="mt-4 rounded-md border border-amber-300/50 bg-amber-300/10 px-4 py-3 text-[14px] text-amber-200">
                            This facility is currently not available for booking.
                        </div>
                    @endunless

                    @if ($errors->any())
                        <div class="mt-4 rounded-md border border-red-400/50 bg-red-400/10 px-4 py-3 text-[14px] text-red-300">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-6">
                        <label for="full_name" class="mb-2 block text-[20px]">Full Name</label>
                        {{-- diambil dari profil; tidak dikirim (booking selalu atas nama akun yang login) --}}
                        <input id="full_name" type="text" readonly value="{{ $me->name }}" class="{{ $field }} cursor-default text-gray-600">
                    </div>

                    <div class="mt-6">
                        <label for="class" class="mb-2 block text-[20px]">Class</label>
                        <div class="relative w-full sm:w-[62%]">
                            <select id="class" name="class" required class="{{ $field }} appearance-none pr-12 text-gray-500 valid:text-[#343434]">
                                <option value="" disabled hidden @selected(! $selectedClass)>Choose your class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class }}" @selected($selectedClass === $class)>{{ $class }}</option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-5 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#343434]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9" /></svg>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="purpose" class="mb-2 block text-[20px]">Booking Purpose</label>
                        <input id="purpose" name="purpose" type="text" required maxlength="255" value="{{ old('purpose') }}"
                            placeholder="e.g. Worship rehearsal" class="{{ $field }}">
                    </div>

                    <div class="mt-auto pt-14">
                        <button
                            type="submit"
                            @disabled(! $isActive)
                            class="h-[58px] w-full rounded-xl bg-[#639178] text-[22px] font-semibold text-white shadow-[0_10px_20px_-8px_rgba(0,0,0,0.5)] transition hover:bg-[#527d66] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Book
                        </button>

                        <a href="{{ route('facilities.index') }}" class="mt-4 block text-center text-[14px] text-white/60 underline-offset-4 hover:text-white hover:underline">
                            Back to Facilities
                        </a>
                    </div>

                </section>

            </form>

        </main>

    </div>

@endsection
