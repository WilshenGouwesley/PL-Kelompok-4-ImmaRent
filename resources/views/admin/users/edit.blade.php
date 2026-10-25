@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')

    @php
        $inputClass = 'h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none';
        $labelClass = 'mb-1 block text-[16px] font-medium text-white';
    @endphp

    <div class="min-h-screen w-full bg-[#f5f5f5]">

        <div class="flex w-full items-end justify-between pt-4">
            @include('layouts.partials.navbar')
            @include('layouts.partials.header')
        </div>

        <main class="flex w-full gap-10 rounded-b-lg bg-[#303030] px-10 pb-10 pt-[35px]">

            @include('layouts.partials.account-sidebar')

            <section class="flex-1">

                <a href="{{ route('admin.users.index') }}" class="mb-4 inline-flex items-center gap-2 text-[15px] font-medium text-white/70 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[16px] w-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Back to Users
                </a>

                <h1 class="text-[28px] font-bold text-white">Edit User</h1>
                <p class="mt-1 text-[15px] text-white/60">Update this account's name, email, and class</p>

                @if ($errors->any())
                    <div class="mt-4 rounded-md border border-red-400/50 bg-red-400/10 px-4 py-3 text-[14px] text-red-300">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-6 flex flex-col gap-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="{{ $labelClass }}">Full Name</label>
                        <input id="name" name="name" type="text" required
                            value="{{ old('name', $user->name) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label for="email" class="{{ $labelClass }}">Email</label>
                        <input id="email" name="email" type="email" required
                            value="{{ old('email', $user->email) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label for="class" class="{{ $labelClass }}">Class <span class="text-white/50">(optional)</span></label>
                        <input id="class" name="class" type="text"
                            value="{{ old('class', $user->class) }}" placeholder="e.g. XII TKJ 3"
                            class="{{ $inputClass }}">
                    </div>

                    {{-- informasi tambahan (hanya baca) --}}
                    <dl class="grid grid-cols-1 gap-4 rounded-md border border-white/10 bg-white/5 p-5 text-[14px] sm:grid-cols-3">
                        <div>
                            <dt class="text-white/50">Role</dt>
                            <dd class="mt-0.5 font-medium text-white">{{ ucfirst($user->role) }}</dd>
                        </div>
                        <div>
                            <dt class="text-white/50">Phone</dt>
                            <dd class="mt-0.5 font-medium text-white">{{ $user->phone_number ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-white/50">Joined</dt>
                            <dd class="mt-0.5 font-medium text-white">{{ $user->created_at->format('d F Y') }}</dd>
                        </div>
                    </dl>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit" class="h-[48px] rounded-md bg-[#639178] px-10 text-[16px] font-semibold text-white transition hover:bg-[#527d66]">
                            Save Changes
                        </button>

                        <a href="{{ route('admin.users.index') }}"
                            class="flex h-[48px] items-center justify-center rounded-md border border-white/30 px-10 text-[16px] font-semibold text-white transition hover:bg-white/5">
                            Cancel
                        </a>
                    </div>
                </form>

                {{-- ================= DANGER ZONE ================= --}}
                @if ($user->role !== 'admin')
                    <div class="mt-10 border-t border-white/10 pt-6">
                        <h2 class="text-[18px] font-semibold text-red-300">Delete account</h2>
                        <p class="mt-1 text-[14px] text-white/60">
                            This permanently removes the account together with all of its bookings and notifications.
                        </p>

                        <form
                            method="POST"
                            action="{{ route('admin.users.destroy', $user) }}"
                            onsubmit="return confirm('Delete this account and all of its bookings? This cannot be undone.')"
                            class="mt-4"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="h-[44px] rounded-md border border-red-400/60 px-6 text-[15px] font-semibold text-red-300 transition hover:bg-red-400/10">
                                Delete Account
                            </button>
                        </form>
                    </div>
                @endif

            </section>

        </main>

    </div>

@endsection
