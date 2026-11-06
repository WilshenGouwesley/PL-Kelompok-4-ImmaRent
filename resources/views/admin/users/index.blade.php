@extends('layouts.app')

@section('title', 'Users - Admin')

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
                    <div data-flash class="animate-slide-down mb-4 rounded-md border border-[#639178]/50 bg-[#639178]/10 px-4 py-3 text-[14px] text-[#9fd6b7]">
                        {{ session('status') }}
                    </div>
                @endif

                <h1 class="text-[28px] font-bold text-white">Users</h1>
                <p class="mt-1 text-[15px] text-white/60">Manage student and staff accounts</p>

                <form method="GET" action="{{ route('admin.users.index') }}" class="relative mt-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="h-[52px] w-full rounded-md bg-[#f5f5f5] px-5 pr-14 text-[15px] text-[#303030] outline-none"
                    >
                    <button type="submit" aria-label="Search" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#303030]">
                        <img src="{{ asset('image/search-icon.png') }}" alt="Search">
                    </button>
                </form>

                <div class="mt-6 overflow-hidden rounded-lg bg-white">

                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-[#e2e2df] text-[15px] text-[#303030]">
                                <th class="px-6 py-4 font-semibold">Name</th>
                                <th class="px-6 py-4 font-semibold">Class</th>
                                <th class="px-6 py-4 font-semibold">Email</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-t border-gray-100 text-[15px] text-[#303030]">
                                    <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->class ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.users.edit', $user) }}" aria-label="Edit" class="inline-flex text-[#639178]">
                                            <img src="{{ asset('image/edit-icon.png') }}" alt="Edit">
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                @if ($users->lastPage() > 1)
                    <div class="mt-8 flex items-center justify-center gap-3">
                        @for ($page = 1; $page <= $users->lastPage(); $page++)
                            <a
                                href="{{ $users->appends(request()->query())->url($page) }}"
                                class="flex h-[42px] w-[42px] items-center justify-center rounded-md text-[16px] font-semibold
                                    {{ $page === $users->currentPage() ? 'bg-[#639178] text-white' : 'bg-white text-[#303030]' }}"
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
