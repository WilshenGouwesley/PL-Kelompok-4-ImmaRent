@extends('layouts.app')

@section('title', 'Facilities - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="w-full rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            <form action="{{ route('facilities.index') }}" method="GET">

                <div class="flex items-center gap-4">

                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search..."
                            class="h-[54px] w-full rounded-md bg-[#f5f5f5] px-5 pr-14 text-[16px] text-[#303030] placeholder-gray-400 focus:outline-none"
                        >
                        <button type="submit" aria-label="Search" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#303030]">
                            <img src="{{ asset('image/search-icon.png') }}" alt="Search">
                        </button>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('filter-panel').classList.toggle('hidden')"
                        class="flex h-[54px] shrink-0 items-center gap-2 rounded-md bg-[#639178] px-6 text-[18px] font-semibold text-white transition duration-200 hover:bg-[#527d66]"
                    >
                        Filter
                        <img src="{{ asset('image/filter-icon.png') }}" alt="Filter">
                    </button>

                </div>

                <div
                    id="filter-panel"
                    class="{{ request()->hasAny(['category', 'location']) ? 'grid' : 'hidden' }} mt-4 grid-cols-1 gap-4 rounded-md bg-[#f5f5f5] p-5 sm:grid-cols-3"
                >
                    <div>
                        <label class="mb-1 block text-[14px] font-medium text-[#303030]">Category</label>
                        <input
                            type="text"
                            name="category"
                            value="{{ request('category') }}"
                            placeholder="e.g. Laboratory"
                            class="h-[44px] w-full rounded-md border border-gray-300 px-3 text-[15px] text-[#303030] focus:outline-none"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-[14px] font-medium text-[#303030]">Location</label>
                        <input
                            type="text"
                            name="location"
                            value="{{ request('location') }}"
                            placeholder="e.g. IELTS Centre"
                            class="h-[44px] w-full rounded-md border border-gray-300 px-3 text-[15px] text-[#303030] focus:outline-none"
                        >
                    </div>

                    <div class="flex items-end gap-3">
                        <button type="submit" class="h-[44px] w-full rounded-md bg-[#639178] text-[15px] font-semibold text-white hover:bg-[#527d66]">
                            Apply
                        </button>
                        @if (request()->hasAny(['search', 'category', 'location']))
                            <a href="{{ route('facilities.index') }}" class="flex h-[44px] w-full items-center justify-center rounded-md border border-gray-300 text-[15px] font-semibold text-[#303030]">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

            </form>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($facilities as $facility)
                    <article class="flex flex-col rounded-lg bg-white p-4">

                        <a href="{{ route('facilities.show', $facility) }}" class="block h-[180px] w-full overflow-hidden rounded-lg">
                            <img
                                src="{{ $facility->image ? asset('storage/' . $facility->image) : asset('image/transparan.png') }}"
                                alt="{{ $facility->name }}"
                                class="h-full w-full object-cover"
                            >
                        </a>

                        <div class="mt-3 flex items-center gap-2">
                            <img src="{{ asset('image/building-icon.png') }}" alt="" class="h-[26px] w-[26px] object-contain">
                            <a href="{{ route('facilities.show', $facility) }}" class="text-[18px] font-semibold text-[#303030] hover:underline">
                                {{ $facility->name }}
                            </a>
                        </div>

                        <div class="mt-1 flex items-center gap-2">
                            <img src="{{ asset('image/location-icon.png') }}" alt="" class="h-[24px] w-[24px] object-contain">
                            <p class="text-[15px] text-gray-500">{{ $facility->location }}</p>
                        </div>

                        @auth
                            <a
                                href="{{ route('bookings.create', $facility) }}"
                                class="mt-4 flex h-[48px] w-full items-center justify-center rounded-md bg-[#639178] text-[16px] font-semibold text-white transition duration-200 hover:bg-[#527d66]"
                            >
                                Book
                            </a>
                        @endauth

                    </article>
                @empty
                    <p class="col-span-full py-10 text-center text-[16px] text-white">
                        No facilities found.
                    </p>
                @endforelse

            </div>

            @if ($facilities->lastPage() > 1)
                <div class="mt-8 flex items-center justify-center gap-3">
                    @for ($page = 1; $page <= $facilities->lastPage(); $page++)
                        <a
                            href="{{ $facilities->appends(request()->query())->url($page) }}"
                            class="flex h-[42px] w-[42px] items-center justify-center rounded-md text-[16px] font-semibold
                                {{ $page === $facilities->currentPage() ? 'bg-[#639178] text-white' : 'bg-white text-[#303030]' }}"
                        >
                            {{ $page }}
                        </a>
                    @endfor
                </div>
            @endif

        </main>

    </div>

@endsection
