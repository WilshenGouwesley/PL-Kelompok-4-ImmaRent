@extends('layouts.app')

@section('title', 'Booking Requests - Admin')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="flex w-full gap-10 rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            @include('layouts.partials.account-sidebar')

            <section class="flex-1">

                @if (session('status'))
                    <div class="mb-4 rounded-md border border-[#639178]/50 bg-[#639178]/10 px-4 py-3 text-[14px] text-[#9fd6b7]">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md border border-red-400/50 bg-red-400/10 px-4 py-3 text-[14px] text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-[28px] font-bold text-white">Booking Requests</h1>
                        <p class="mt-1 text-[15px] text-white/60">Approve or reject facility requests</p>
                    </div>

                    <form method="GET" action="{{ route('admin.bookings.index') }}">
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="h-[44px] rounded-full bg-white px-5 text-[15px] font-medium text-[#303030] outline-none"
                        >
                            <option value="" {{ request('status') ? '' : 'selected' }}>All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>

                <div class="mt-6 flex flex-col gap-4">

                    @forelse ($bookings as $booking)
                        <article class="flex items-start gap-5 rounded-lg bg-white p-4">

                            <div class="h-[100px] w-[130px] shrink-0 overflow-hidden rounded-lg">
                                <img
                                    src="{{ $booking->facility->image ? asset('storage/' . $booking->facility->image) : asset('image/transparan.png') }}"
                                    alt="{{ $booking->facility->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>

                            <div class="flex-1">
                                <h2 class="text-[18px] font-semibold text-[#303030]">{{ $booking->facility->name }}</h2>

                                <div class="mt-2 flex flex-wrap items-center gap-x-6 gap-y-1 text-[14px] text-gray-500">
                                    <span class="inline-flex items-center gap-2">
                                        <img src="{{ asset('image/calendar-icon.png') }}" alt="">
                                        {{ $booking->booking_date->format('d M Y') }}
                                    </span>
                                    <span class="inline-flex items-center gap-2">
                                        <img src="{{ asset('image/calendar-icon.png') }}" alt="">
                                        {{ \Illuminate\Support\Carbon::parse($booking->start_time)->format('H:i') }}
                                        - {{ \Illuminate\Support\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </span>
                                    <span class="inline-flex items-center gap-2">
                                        <img src="{{ asset('image/profile-icon.png') }}" alt="">
                                        {{ $booking->user->name }} &bull; {{ $booking->user->class }}
                                    </span>
                                    <span class="inline-flex items-center gap-2">
                                        <img src="{{ asset('image/edit-icon.png') }}" alt="">
                                        {{ $booking->purpose }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex w-[220px] shrink-0 flex-col items-end gap-3">

                                @if ($booking->status === 'pending')
                                    <span class="rounded-full bg-[#f3c98b] px-5 py-2 text-[14px] font-semibold text-[#7a5b1e]">
                                        Pending
                                    </span>

                                    {{-- pesan (dipakai sebagai alasan penolakan kalau ditolak) --}}
                                    <form id="reject-form-{{ $booking->id }}" method="POST" action="{{ route('admin.bookings.reject', $booking) }}" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <input
                                            type="text"
                                            name="rejection_reason"
                                            placeholder="Type your message..."
                                            class="h-[38px] w-full rounded-md bg-[#f5f5f5] px-3 text-[13px] text-[#303030] outline-none"
                                        >
                                    </form>

                                    <div class="flex gap-2 self-end">
                                        <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" aria-label="Approve" class="flex h-[38px] w-[38px] items-center justify-center rounded-md bg-[#9fe3c8] text-[#166b47] transition hover:bg-[#7fd4b0]">
                                                <img src="{{ asset('image/check-icon.png') }}" alt="">
                                            </button>
                                        </form>

                                        <button type="submit" form="reject-form-{{ $booking->id }}" aria-label="Reject" class="flex h-[38px] w-[38px] items-center justify-center rounded-md bg-[#f5a3a3] text-[#8a1f1f] transition hover:bg-[#ef8080]">
                                            <img src="{{ asset('image/x-icon.png') }}" alt="">
                                        </button>
                                    </div>
                                @elseif ($booking->status === 'approved')
                                    <span class="rounded-full bg-[#9fe3c8] px-6 py-2 text-[14px] font-semibold text-[#166b47]">Approved</span>
                                @elseif ($booking->status === 'rejected')
                                    <span class="rounded-full bg-[#f5a3a3] px-6 py-2 text-[14px] font-semibold text-[#8a1f1f]">Rejected</span>
                                @else
                                    <span class="rounded-full bg-gray-300 px-6 py-2 text-[14px] font-semibold text-gray-700">Cancelled</span>
                                @endif

                            </div>

                        </article>
                    @empty
                        <p class="py-10 text-center text-[16px] text-white">No booking requests found.</p>
                    @endforelse

                </div>

                @if ($bookings->lastPage() > 1)
                    <div class="mt-8 flex items-center justify-center gap-3">
                        @for ($page = 1; $page <= $bookings->lastPage(); $page++)
                            <a
                                href="{{ $bookings->appends(request()->query())->url($page) }}"
                                class="flex h-[42px] w-[42px] items-center justify-center rounded-md text-[16px] font-semibold
                                    {{ $page === $bookings->currentPage() ? 'bg-[#639178] text-white' : 'bg-white text-[#303030]' }}"
                            >
                                {{ $page }}
                            </a>
                        @endfor
                    </div>
                @endif

            </section>

        </main>

    </div>

@endsection
