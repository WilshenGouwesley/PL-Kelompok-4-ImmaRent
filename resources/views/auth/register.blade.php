@extends('layouts.app')

@section('title', 'Register - Reservasi Fasilitas Sekolah')

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
                        type="name"
                        placeholder="Enter your full name"
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
                            <img id="passwordIcon" src="{{ asset('image/PW-icon.png') }}" class="h-[12px] w-[15px]" alt="Show password">
                        </span>
                    </button>

                </div>

                {{-- PASSWORD --}}
                <div class="relative mt-[16px]">

                    <label
                        for="confirm-pw"
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
                            <img id="passwordIcon" src="{{ asset('image/PW-icon.png') }}" class="h-[12px] w-[15px]" alt="Show password">
                        </span>
                    </button>

                </div>

                {{-- REGISTER BUTTON --}}
                <a
                    href="{{ route('login') }}"
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
                        text-[#639178]
                        transition
                        duration-200
                        hover:bg-[#639178]
                        hover:text-white
                    "
                >
                    Register
                </a>


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