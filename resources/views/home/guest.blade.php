@extends('layouts.app')

@section('title', 'Beranda - Reservasi Fasilitas Sekolah')

@section('content')

<div class="min-h-screen w-full bg-[#f5f5f5]">

    {{-- ================= HEADER + NAVIGATION ================= --}}
    <div class="flex w-full items-end justify-between px-6 pt-4">

    {{-- NAVIGATION --}}
    <nav class="flex items-end gap-1">

    {{-- HOME --}}
    <a
        href="{{ route('home') }}"
        class="flex h-[84px] w-[190px] items-center justify-center rounded-t-lg bg-[#303030] text-lg font-semibold text-white"
    >
        Home
    </a>


    {{-- FACILITIES --}}
    <a
        href="{{ route('facilities.index') }}"
        class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#303030] text-lg font-semibold text-white"
    >
        Facilities
    </a>


    {{-- LOGIN --}}
    <a
        href="{{ route('login') }}"
        class="flex h-[42px] w-[190px] items-center justify-center rounded-t-lg bg-[#303030] text-lg font-semibold text-white"
    >
        Login
    </a>

    </nav>

    {{-- HEADER --}}
    @include('layouts.partials.header')

    </div>


    {{-- ================= BODY ================= --}}
    <main class="w-full bg-[#303030] px-4 pb-10 pt-[35px]">

        {{-- ================= HERO ================= --}}
        <section
            class="
                flex min-h-[320px] w-full
                items-center justify-between
            "
        >

            {{-- TEXT --}}
            <div class="w-1/2">

                <h1
                    class="
                        text-[48px]
                        font-medium
                        leading-[1.1]
                        text-white
                    "
                >
                    Big ideas need the<br>
                    right space.
                </h1>


                <p
                    class="
                        mt-4
                        max-w-[480px]
                        text-[14px]
                        leading-5
                        text-white
                    "
                >
                    Explore our school facilities, choose the perfect
                    one for your plans, and reserve it effortlessly.
                </p>


                <a
                    href="{{ route('login') }}"
                    class="
                        mt-7
                        flex h-[40px] w-[157px]
                        items-center justify-center
                        rounded-md
                        bg-[#639178]
                        text-[15px]
                        font-semibold
                        text-white
                        transition
                        duration-200
                        hover:bg-[#527d66]
                    "
                >
                    Login
                </a>

            </div>


            {{-- GAMBAR SEKOLAH --}}
            <div
                class="
                    flex w-1/2
                    items-center
                    justify-end
                "
            >

                <img
                    src="{{ asset('image/building-picture.png') }}"
                    alt="School Building"
                    class="w-[470px] max-w-full object-contain"
                >

            </div>

        </section>


        {{-- ================= FEATURED FACILITIES ================= --}}
        <section
            class="
                relative
                w-full
                rounded-lg
                bg-white
                px-7
                py-6
            "
        >

            <h2
                class="
                    text-[25px]
                    font-medium
                    text-black
                "
            >
                Featured Facilities
            </h2>


            {{-- CAROUSEL --}}
<div class="relative mt-8 flex w-full items-center">

    {{-- PREVIOUS BUTTON --}}
    <button
        type="button"
        class="absolute -left-[48px] z-10 flex h-[48px] w-[48px] items-center justify-center border-0 bg-transparent p-0 transition duration-200 hover:scale-110"
    >
        <img
            src="{{ asset('image/left-button.png') }}"
            alt="Previous"
            class="h-[48px] w-[48px] object-contain"
        >
    </button>


    {{-- TRACK --}}
    <div class="flex w-full gap-6 overflow-hidden">

        @forelse ($featuredFacilities as $facility)

            <article class="min-w-[calc(25%-18px)] flex-1">

                {{-- IMAGE --}}
                <div
                    class="h-[115px] w-full overflow-hidden rounded-lg bg-[#eeeeee]"
                >

                    @if ($facility->image)

                        <img
                            src="{{ asset('storage/' . $facility->image) }}"
                            alt="{{ $facility->name }}"
                            class="h-full w-full object-cover"
                        >

                    @endif

                </div>


                {{-- NAME --}}
                <p class="mt-3 text-[14px] font-semibold text-[#303030]">
                    {{ $facility->name }}
                </p>


                {{-- LOCATION --}}
                <p class="mt-1 text-[11px] text-gray-500">
                    {{ $facility->location }}
                </p>

            </article>

        @empty

            <p class="py-8 text-[14px] text-gray-600">
                Belum ada fasilitas yang tersedia.
            </p>

        @endforelse

    </div>


    {{-- NEXT BUTTON --}}
    <button
        type="button"
        class="absolute -right-[48px] z-10 flex h-[48px] w-[48px] items-center justify-center border-0 bg-transparent p-0 transition duration-200 hover:scale-110"
    >
        <img
            src="{{ asset('image/right-button.png') }}"
            alt="Next"
            class="h-[48px] w-[48px] object-contain"
        >
    </button>

</div>

        </section>

    </main>


</div>

@endsection