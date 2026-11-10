@extends('layouts.app')

@section('title', 'Booking Details - Reservasi Fasilitas Sekolah')

@section('content')

    @php
        $badge = match ($booking->status) {
            'approved' => 'bg-[#9BDCCB]',
            'pending' => 'bg-[#F6D19B]',
            'rejected' => 'bg-[#F9B4B4]',
            default => 'bg-[#DDDDD9]',
        };

        $statusNote = match ($booking->status) {
            'approved' => 'Approved on ' . ($booking->approved_at?->format('d F Y') ?? '-'),
            'rejected' => 'Rejected on ' . ($booking->rejected_at?->format('d F Y') ?? '-'),
            'cancelled' => 'Cancelled on ' . ($booking->cancelled_at?->format('d F Y') ?? '-'),
            default => 'Waiting for approval',
        };
    @endphp

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="w-full rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            <a href="{{ route('bookings.index') }}" class="mb-6 inline-flex items-center gap-2 text-[16px] font-medium text-white hover:text-[#9fbfae]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Back to Bookings
            </a>

            @if (session('status'))
                <div data-flash class="animate-slide-down mb-4 rounded-md border border-[#639178]/50 bg-[#639178]/10 px-4 py-3 text-[14px] text-[#9fd6b7]">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-400/50 bg-red-400/10 px-4 py-3 text-[14px] text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="grid grid-cols-1 gap-8 rounded-lg bg-white p-7 md:grid-cols-5">

                <div class="h-[240px] w-full overflow-hidden rounded-lg md:col-span-2 md:h-[300px]">
                    <img
                        src="{{ $booking->facility->image ? asset('storage/' . $booking->facility->image) : asset('image/transparan.png') }}"
                        alt="{{ $booking->facility->name }}"
                        class="h-full w-full object-cover"
                    >
                </div>

                <div class="flex flex-col md:col-span-3">

                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h1 class="text-[28px] font-semibold leading-tight text-[#303030]">{{ $booking->facility->name }}</h1>
                            <p class="mt-1 text-[14px] text-gray-500">Booking #{{ $booking->id }}</p>
                        </div>

                        <div class="flex flex-col items-center">
                            <span class="rounded-full px-6 py-1.5 text-[13px] font-semibold text-[#343434] {{ $badge }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <span class="mt-1 text-[12px] text-gray-500">{{ $statusNote }}</span>
                        </div>
                    </div>

                    <dl class="mt-6 grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-[13px] text-gray-500">Date</dt>
                            <dd class="mt-0.5 text-[16px] font-medium text-[#303030]">{{ $booking->booking_date->format('l, d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-[13px] text-gray-500">Time</dt>
                            <dd class="mt-0.5 text-[16px] font-medium text-[#303030]">
                                {{ \Illuminate\Support\Carbon::parse($booking->start_time)->format('H:i') }}
                                - {{ \Illuminate\Support\Carbon::parse($booking->end_time)->format('H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-[13px] text-gray-500">Location</dt>
                            <dd class="mt-0.5 text-[16px] font-medium text-[#303030]">{{ $booking->facility->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-[13px] text-gray-500">Class</dt>
                            <dd class="mt-0.5 text-[16px] font-medium text-[#303030]">{{ $booking->class ?: $booking->user->class ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[13px] text-gray-500">Purpose</dt>
                            <dd class="mt-0.5 text-[16px] font-medium text-[#303030]">{{ $booking->purpose }}</dd>
                        </div>
                        <div>
                            <dt class="text-[13px] text-gray-500">Requested on</dt>
                            <dd class="mt-0.5 text-[16px] font-medium text-[#303030]">{{ $booking->created_at->format('d F Y, H:i') }}</dd>
                        </div>
                    </dl>

                    @if ($booking->status === 'rejected' && $booking->rejection_reason)
                        <div class="mt-6 rounded-md border border-red-200 bg-red-50 px-4 py-3">
                            <p class="text-[13px] font-semibold text-red-700">Message from admin</p>
                            <p class="mt-1 text-[14px] text-red-600">{{ $booking->rejection_reason }}</p>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3 pt-2">
                        <a
                            href="{{ route('bookings.index') }}"
                            class="flex h-[46px] items-center justify-center rounded-md border border-gray-300 px-6 text-[15px] font-semibold text-[#303030] transition hover:bg-gray-50"
                        >
                            Back
                        </a>

                        @if (in_array($booking->status, ['pending', 'approved'], true))
                            <form
                                method="POST"
                                action="{{ route('bookings.cancel', $booking) }}"
                                onsubmit="return confirm('Cancel this booking?')"
                            >
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="flex h-[46px] items-center justify-center rounded-md border border-red-300 px-6 text-[15px] font-semibold text-red-600 transition hover:bg-red-50"
                                >
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>

                </div>

            </section>

        </main>

    </div>

@endsection
