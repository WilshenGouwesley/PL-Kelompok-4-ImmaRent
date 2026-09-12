@extends('layouts.app')

@section('title', 'Facilities - Admin')

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

                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-[28px] font-bold text-white">Facilities</h1>
                        <p class="mt-1 text-[15px] text-white/60">Add, edit, or retire bookable spaces</p>
                    </div>

                    <a
                        href="{{ route('admin.facilities.create') }}"
                        class="flex h-[44px] shrink-0 items-center gap-2 rounded-md bg-[#639178] px-5 text-[15px] font-semibold text-white transition hover:bg-[#527d66]"
                    >
                        <img src="{{ asset('image/plus-icon.png') }}" alt="">
                        Add Facility
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.facilities.index') }}" class="relative mt-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search..."
                        class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-5 pr-14 text-[15px] text-[#303030] outline-none"
                    >
                    <button type="submit" aria-label="Search" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#303030]">
                        <img src="{{ asset('image/search-icon.png') }}" alt="">
                    </button>
                </form>

                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    @forelse ($facilities as $facility)
                        <article class="relative flex flex-col rounded-lg bg-white p-4">

                            <div class="h-[150px] w-full overflow-hidden rounded-lg">
                                <img
                                    src="{{ $facility->image ? asset('storage/' . $facility->image) : asset('image/transparan.png') }}"
                                    alt="{{ $facility->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>

                            <div class="absolute right-3 top-3 flex gap-2">
                                <a
                                    href="{{ route('admin.facilities.edit', $facility) }}"
                                    aria-label="Edit"
                                    class="flex h-[30px] w-[30px] items-center justify-center rounded-md bg-white/90 text-[#303030] shadow"
                                >
                                    <img src="{{ asset('image/edit-icon.png') }}" alt="">
                                </a>

                                <form method="POST" action="{{ route('admin.facilities.destroy', $facility) }}"
                                    onsubmit="return confirm('Delete this facility?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Delete" class="flex h-[30px] w-[30px] items-center justify-center rounded-md bg-white/90 text-red-600 shadow">
                                        <img src="{{ asset('image/trash-icon.png') }}" alt="">
                                    </button>
                                </form>
                            </div>

                            <h2 class="mt-3 text-[17px] font-semibold text-[#303030]">{{ $facility->name }}</h2>
                            <div class="mt-1 flex items-center gap-2 text-[14px] text-gray-500">
                                <img src="{{ asset('image/location-icon.png') }}" alt="">
                                {{ $facility->location }}
                            </div>

                        </article>
                    @empty
                        <p class="col-span-full py-10 text-center text-[16px] text-white">No facilities yet.</p>
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

            </section>

        </main>

    </div>

@endsection
