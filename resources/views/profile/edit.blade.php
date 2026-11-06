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
                    <div data-flash class="animate-slide-down mt-4 rounded-md border border-[#639178]/50 bg-[#639178]/10 px-4 py-3 text-[14px] text-[#9fd6b7]">
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

                    {{-- ================= FOTO PROFIL ================= --}}
                    <div class="flex items-center gap-5">

                        <div class="h-[96px] w-[96px] shrink-0 overflow-hidden rounded-full bg-[#f5f5f5]/10 ring-2 ring-white/10">
                            <img
                                id="avatar-preview"
                                src="{{ $user->avatar_url ?? asset('image/transparan.png') }}"
                                alt="{{ $user->name }}"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <div>
                            <label for="avatar" class="mb-1 block text-[16px] font-medium text-white">Profile Photo</label>

                            <input
                                id="avatar"
                                name="avatar"
                                type="file"
                                accept="image/png,image/jpeg,image/webp"
                                class="block text-[14px] text-white/80 file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-[#639178] file:px-4 file:py-2 file:text-[14px] file:font-semibold file:text-white hover:file:bg-[#527d66]"
                            >

                            <p class="mt-1 text-[13px] text-white/50">JPG, PNG, or WEBP. Max 2 MB.</p>
                            <p id="avatar-error" class="mt-1 text-[13px] text-red-300">@error('avatar'){{ $message }}@enderror</p>

                            @if ($user->avatar)
                                <label class="mt-1 inline-flex cursor-pointer items-center gap-2 text-[14px] text-white/70">
                                    <input id="remove_avatar" name="remove_avatar" type="checkbox" value="1" class="h-[16px] w-[16px] accent-[#639178]">
                                    Remove current photo
                                </label>
                            @endif
                        </div>

                    </div>

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

        <script>
            (function () {
                const input = document.getElementById('avatar');
                const preview = document.getElementById('avatar-preview');
                const remove = document.getElementById('remove_avatar');
                const error = document.getElementById('avatar-error');
                const placeholder = @json(asset('image/transparan.png'));
                const original = preview.src;
                const allowed = ['image/jpeg', 'image/png', 'image/webp'];

                function reset(message) {
                    input.value = '';
                    preview.src = original;
                    error.textContent = message;
                }

                input.addEventListener('change', function () {
                    error.textContent = '';
                    const file = input.files[0];

                    if (! file) { preview.src = original; return; }
                    if (! allowed.includes(file.type)) { reset('Please choose a JPG, PNG, or WEBP image.'); return; }
                    if (file.size > 2 * 1024 * 1024) { reset('The photo must not be larger than 2 MB.'); return; }

                    preview.src = URL.createObjectURL(file);   // pratinjau sebelum disimpan
                    if (remove) { remove.checked = false; }
                });

                if (remove) {
                    remove.addEventListener('change', function () {
                        if (remove.checked) { input.value = ''; error.textContent = ''; preview.src = placeholder; }
                        else { preview.src = original; }
                    });
                }
            })();
        </script>

    </div>

@endsection