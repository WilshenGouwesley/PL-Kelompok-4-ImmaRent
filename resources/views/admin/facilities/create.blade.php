@extends('layouts.app')

@section('title', 'Add Facility - Admin')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="flex w-full gap-10 rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            @include('layouts.partials.account-sidebar')

            <section class="flex-1">

                <a href="{{ route('admin.facilities.index') }}" class="mb-4 inline-flex items-center gap-2 text-[15px] font-medium text-white/70 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[16px] w-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Back to Facilities
                </a>

                <h1 class="text-[28px] font-bold text-white">Add Facility</h1>
                <p class="mt-1 text-[15px] text-white/60">Create a new bookable space or equipment</p>

                @include('admin.facilities.partials.form', [
                    'facility' => null,
                    'action' => route('admin.facilities.store'),
                    'method' => 'POST',
                    'submitLabel' => 'Add Facility',
                ])

            </section>

        </main>

    </div>

@endsection
