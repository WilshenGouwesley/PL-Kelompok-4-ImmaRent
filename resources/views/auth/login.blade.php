@extends('layouts.app')

@section('title', 'Login - Reservasi Fasilitas Sekolah')

@section('content')

<div class="h-screen w-full overflow-hidden bg-[#f5f5f5]">

    {{-- ================= LOGIN CONTENT ================= --}}
    <main class="flex min-h-screen flex-col items-center">

        {{-- ================= TITLE ================= --}}
        <section class="pt-[85px] text-center">

            <h1
                class="
                    text-[64px]
                    font-bold
                    leading-tight
                    text-[#343434]
                "
            >
                Welcome back! Your space awaits.
            </h1>

            <p
                class="
                    mt-2
                    text-[25px]
                    font-medium
                    text-[#343434]
                "
            >
                Log in to access your bookings and find the right facility for what’s next.
            </p>

        </section>


        {{-- ================= PHONE / LOGIN CONTAINER ================= --}}
        <section
            class="
                relative
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

            {{-- ================= LOGIN FORM ================= --}}
            <form class="flex flex-col w-full gap-[10px]">

                {{-- EMAIL --}}
                <div class="relative">

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
                        type="email"
                        placeholder="Ex: name.000@ski.sch.id"
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
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="
                            h-[41px]
                            w-full
                            rounded-[5px]
                            border-[2px]
                            border-[#8d8d8d]
                            bg-transparent
                            px-[11px]
                            pr-[35px]
                            text-[12px]
                            text-[#343434]
                            outline-none
                            transition
                            focus:border-[#639178]
                        "
                    >

                    {{-- PASSWORD ICON --}}
                    <button
                        type="button"
                        id="togglePassword"
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
                        <span class="text-[12px] text-gray-400 ">
                            <img id="passwordIcon" src="{{ asset('image/PW-icon.png') }}" class="h-[13px] w-[15px]" alt="Show password">
                        </span>
                    </button>

                </div>


                {{-- REMEMBER + FORGOT --}}
                <div
                    class="
                        mt-[11px]
                        flex
                        items-center
                        justify-between
                    "
                >

                    <label class="flex items-center gap-[7px]">

                        <input
                            type="checkbox"
                            class="
                                h-[17px]
                                w-[17px]
                                rounded-[2px]
                                border-[#343434]
                                accent-[#639178]
                            "
                        >

                        <span class="text-[12px] text-[#343434]">
                            Keep me logged in
                        </span>

                    </label>


                    <a
                        href="#"
                        class="
                            text-[12px]
                            text-[#555555]
                            underline
                        "
                    >
                        Forgot Password?
                    </a>

                </div>


                {{-- LOGIN BUTTON --}}
                <a
                    href="{{ route('home') }}"
                    class="
                        flex
                        mt-[20px]
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
                        text-[#639178]
                        transition
                        duration-200
                        hover:bg-[#639178]
                        hover:text-white
                    "
                >
                    Log In
                </a>


                {{-- ================= OR ================= --}}
                <div class="my-[13px] flex items-center gap-[8px]">

                    <div class="h-px flex-1 bg-[#a7a7a7]"></div>

                    <span class="text-[12px] text-[#8a8a8a]">
                        OR
                    </span>

                    <div class="h-px flex-1 bg-[#a7a7a7]"></div>

                </div>


                {{-- ================= SOCIAL LOGIN ================= --}}
                <div class="flex justify-between gap-[12px]">

                    {{-- GOOGLE --}}
                    <button
                        type="button"
                        class="
                            flex
                            h-[35px]
                            w-[105px]
                            items-center
                            justify-center
                            gap-[6px]
                            rounded-[4px]
                            border
                            border-[#bcbcbc]
                            bg-white
                            text-[12px]
                            text-[#343434]
                            transition
                            hover:bg-gray-50
                        "
                    >

                        <span class="font-bold text-[#343434] size-[15px]">
                            <img src="{{ asset("image/google.png") }}" alt="">
                        </span>

                        Google

                    </button>


                    {{-- MICROSOFT --}}
                    <button
                        type="button"
                        class="
                            flex
                            h-[35px]
                            w-[105px]
                            items-center
                            justify-center
                            gap-[5px]
                            rounded-[4px]
                            border
                            border-[#bcbcbc]
                            bg-white
                            text-[9px]
                            text-[#303030]
                            transition
                            hover:bg-gray-50
                        "
                    >

                        <span class="font-bold text-[#343434] size-[15px]">
                            <img src="{{ asset("image/microsoft.png") }}" alt="">
                        </span>

                        Microsoft

                    </button>

                </div>


                {{-- ================= CREATE ACCOUNT ================= --}}
                <p
                    class="
                        mt-[11px]
                        text-center
                        text-[12px]
                        text-[#303030]
                    "
                >
                    New here?

                    <a
                        href="{{ route('register') }}"
                        class="font-bold underline"
                    >
                        Create an account!
                    </a>

                </p>

            </form>

        </section>

    </main>

</div>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        if (password.type === 'password') {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
    });
</script>

@endsection