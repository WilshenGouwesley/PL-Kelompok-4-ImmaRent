@extends('layouts.app')

@section('title', 'Register - Reservasi Fasilitas Sekolah')

@section('content')

<div class="h-screen w-full overflow-hidden bg-[#f5f5f5]">

    {{-- ================= LOGIN CONTENT ================= --}}
    <main class="flex min-h-screen flex-col items-center">

        {{-- ================= TITLE ================= --}}
        <section class="animate-fade-up pt-[85px] text-center">

            <h1
                class="
                    text-[64px]
                    font-bold
                    leading-tight
                    text-[#343434]
                "
            >
                Got plans? We’ve got the space.
            </h1>

            <p
                class="
                    mt-2
                    text-[25px]
                    font-medium
                    text-[#343434]
                "
            >
                Sign in to find and reserve the perfect facility for your next activity.
            </p>

        </section>


        {{-- ================= PHONE / LOGIN CONTAINER ================= --}}
        <section
            class="
                animate-fade-up [animation-delay:150ms] relative
                mt-[37px]
                w-[400px]
                min-h-[600px]
                rounded-t-[16px]
                border-[4px]
                border-[#3b3b3b]
                bg-[#f8f8f8]
                px-[20px]
                pt-[40px]
            "
        >

            {{-- FIX: pesan error validasi dari RegisterController@store (nama dipakai, password tidak cocok, dll) --}}
            @if ($errors->any())
                <div class="mb-[10px] rounded-[5px] border border-red-300 bg-red-50 px-[11px] py-[8px] text-[12px] text-red-600">
                    <ul class="list-disc pl-[16px]">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col w-full gap-[10px]">
                @csrf

                {{-- NAME --}}
                <div class="relative">

                    <label
                        for="name"
                        class="
                            absolute
                            -top-[10px]
                            left-[14px]
                            bg-[#f8f8f8]
                            px-[5px]
                            text-[15px]
                            font-medium
                            text-[#343434]
                        "
                    >
                        Name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        required
                        class="
                            h-[41px]
                            w-full
                            rounded-[5px]
                            border-[2px]
                            border-[#8d8d8d]
                            bg-transparent
                            px-[11px]
                            text-[12px]
                            text-[#303030]
                            outline-none
                            transition
                            focus:border-[#639178]
                        "
                    >

                </div>

                {{-- EMAIL --}}
                <div class="relative mt-[16px]">

                    <label
                        for="email"
                        class="
                            absolute
                            -top-[10px]
                            left-[14px]
                            bg-[#f8f8f8]
                            px-[5px]
                            text-[15px]
                            font-medium
                            text-[#343434]
                        "
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="Ex: name.000@ski.sch.id"
                        required
                        class="
                            h-[41px]
                            w-full
                            rounded-[5px]
                            border-[2px]
                            border-[#8d8d8d]
                            bg-transparent
                            px-[11px]
                            text-[12px]
                            text-[#303030]
                            outline-none
                            transition
                            focus:border-[#639178]
                        "
                    >

                </div>


                {{-- PASSWORD --}}
                <div class="relative mt-[16px]">

                    <label
                        for="password"
                        class="
                            absolute
                            -top-[10px]
                            left-[14px]
                            bg-[#f8f8f8]
                            px-[5px]
                            text-[15px]
                            font-medium
                            text-[#343434]
                        "
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        required
                        class="
                            h-[41px]
                            w-full
                            rounded-[5px]
                            border-[2px]
                            border-[#8d8d8d]
                            bg-transparent
                            px-[11px]
                            pr-[40px]
                            text-[12px]
                            text-[#343434]
                            outline-none
                            transition
                            focus:border-[#639178]
                        "
                    >

                    <button
                        type="button"
                        data-toggle-password="password"
                        aria-label="Show or hide password"
                        class="
                            absolute
                            right-[8px]
                            top-1/2
                            -translate-y-1/2
                            border-0
                            bg-transparent
                            p-0
                        "
                    >
                        <img
                            src="{{ asset('image/PW-icon.png') }}"
                            alt="Show password"
                            class="h-[15px] w-[17px] object-contain"
                        >
                    </button>

                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="relative mt-[16px]">

                    <label
                        for="password_confirmation"
                        class="
                            absolute
                            -top-[10px]
                            left-[14px]
                            bg-[#f8f8f8]
                            px-[5px]
                            text-[15px]
                            font-medium
                            text-[#343434]
                        "
                    >
                        Confirm Password
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Confirm your password"
                        required
                        class="
                            h-[41px]
                            w-full
                            rounded-[5px]
                            border-[2px]
                            border-[#8d8d8d]
                            bg-transparent
                            px-[11px]
                            pr-[40px]
                            text-[12px]
                            text-[#343434]
                            outline-none
                            transition
                            focus:border-[#639178]
                        "
                    >

                    <button
                        type="button"
                        data-toggle-password="password_confirmation"
                        aria-label="Show or hide confirm password"
                        class="
                            absolute
                            right-[8px]
                            top-1/2
                            -translate-y-1/2
                            border-0
                            bg-transparent
                            p-0
                        "
                    >
                        <img
                            src="{{ asset('image/PW-icon.png') }}"
                            alt="Show password"
                            class="h-[15px] w-[17px] object-contain"
                        >
                    </button>

                </div>

                {{-- REGISTER BUTTON --}}
                <button
                    type="submit"
                    class="
                        mt-[20px]
                        flex
                        h-[40px]
                        w-full
                        items-center
                        justify-center
                        rounded-[5px]
                        border-[2px]
                        border-[#639178]
                        bg-[#639178]
                        text-white
                        font-semibold
                        transition
                        duration-200
                        hover:bg-[#527d66]
                    "
                >
                    Register
                </button>


                {{-- ================= LOGIN ================= --}}
                <p
                    class="
                        mt-[11px]
                        text-center
                        text-[12px]
                        text-[#303030]
                    "
                >
                    Already have an account?

                    <a
                        href="{{ route('login') }}"
                        class="font-bold underline"
                    >
                        Log In Now!
                    </a>

                </p>

            </form>

        </section>

    </main>

</div>
<script>
    document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.togglePassword);

            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        });
    });
</script>

@endsection
