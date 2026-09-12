@extends('layouts.app')

@section('title', 'Personal Information - Reservasi Fasilitas Sekolah')

@section('content')

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="flex w-full gap-10 rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            @include('layouts.partials.account-sidebar')

            <section class="flex-1">

                <h1 class="text-[28px] font-bold text-white">Personal Information</h1>

                @if (session('status'))
                    <div class="mt-4 rounded-md border border-[#639178]/50 bg-[#639178]/10 px-4 py-3 text-[14px] text-[#9fd6b7]">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-4 rounded-md border border-red-400/50 bg-red-400/10 px-4 py-3 text-[14px] text-red-300">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="mb-1 block text-[16px] font-medium text-white">Full Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none"
                        >
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-[16px] font-medium text-white">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none"
                        >
                    </div>

                    <div>
                        <span class="mb-2 block text-[16px] font-medium text-white">Gender</span>
                        <div class="flex items-center gap-8">
                            <label class="flex items-center gap-2 text-[15px] text-white">
                                <input type="radio" name="gender" value="male" class="h-[18px] w-[18px] accent-[#639178]"
                                    {{ old('gender', $user->gender) === 'male' ? 'checked' : '' }}>
                                Male
                            </label>
                            <label class="flex items-center gap-2 text-[15px] text-white">
                                <input type="radio" name="gender" value="female" class="h-[18px] w-[18px] accent-[#639178]"
                                    {{ old('gender', $user->gender) === 'female' ? 'checked' : '' }}>
                                Female
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="class" class="mb-1 block text-[16px] font-medium text-white">Class</label>
                        <input
                            id="class"
                            name="class"
                            type="text"
                            value="{{ old('class', $user->class) }}"
                            placeholder="e.g. XII TKJ 3"
                            class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none"
                        >
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="phone_number" class="mb-1 block text-[16px] font-medium text-white">Phone Number</label>
                            <input
                                id="phone_number"
                                name="phone_number"
                                type="text"
                                value="{{ old('phone_number', $user->phone_number) }}"
                                placeholder="+62 8xxx xxxx xxxx"
                                class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none"
                            >
                        </div>

                        <div>
                            <label for="date_of_birth" class="mb-1 block text-[16px] font-medium text-white">Date of Birth</label>
                            <input
                                id="date_of_birth"
                                name="date_of_birth"
                                type="date"
                                value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"
                                class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none"
                            >
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="h-[48px] w-full rounded-md bg-[#639178] text-[16px] font-semibold text-white transition hover:bg-[#527d66] sm:w-[200px]">
                            Save Changes
                        </button>
                    </div>

                </form>

            </section>

        </main>

    </div>

@endsection
