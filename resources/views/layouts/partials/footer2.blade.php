<footer class="w-full bg-[#f5f5f5] text-[#202020]">

    {{-- ================= FOOTER CONTENT ================= --}}
    <div class="flex w-full items-start justify-between px-[63px] py-[25px]">

        {{-- ABOUT --}}
        <div class="flex flex-col">
            <h3 class="text-[23px] font-semibold">
                About
            </h3>

            <div class="mt-[19px] flex flex-col gap-[5px] text-[13px]">
                <a href="#" class="transition hover:text-[#639178]">
                    Blog
                </a>

                <a href="#" class="transition hover:text-[#639178]">
                    Meet The Team
                </a>

                <a href="#" class="transition hover:text-[#639178]">
                    Contact Us
                </a>
            </div>
        </div>


        {{-- SUPPORT --}}
        <div class="mr-auto ml-[65px] flex flex-col">
            <h3 class="text-[23px] font-semibold">
                Support
            </h3>

            <div class="mt-[19px] flex flex-col gap-[5px] text-[13px]">
                <a href="#" class="transition hover:text-[#639178]">
                    Contact Us
                </a>

                <a href="#" class="transition hover:text-[#639178]">
                    Return
                </a>

                <a href="#" class="transition hover:text-[#639178]">
                    FAQ
                </a>

                <a href="#" class="transition hover:text-[#639178]">
                    Help
                </a>
            </div>
        </div>

        {{-- SOCIAL MEDIA --}}
        <div class="flex flex-col items-start gap-[15px] self-end">

            <p class="text-[19px] font-medium">
                Social Media
            </p>

            <div class="flex items-center gap-[12px]">

                {{-- X --}}
                <img
                    src="{{ asset('image/x.png') }}"
                    alt="X"
                    class="h-[28px] w-[28px]"
                >

                {{-- Instagram --}}
                <img
                    src="{{ asset('image/instagram.png') }}"
                    alt="Instagram"
                    class="h-[28px] w-[28px]"
                >

                {{-- Facebook --}}
                <img
                    src="{{ asset('image/facebook.png') }}"
                    alt="Facebook"
                    class="h-[28px] w-[28px]"
                >

                {{-- LinkedIn --}}
                <img
                    src="{{ asset('image/linkedin.png') }}"
                    alt="LinkedIn"
                    class="h-[28px] w-[28px]"
                >

            </div>

        </div>

    </div>


    {{-- ================= COPYRIGHT ================= --}}
    <div class="w-full border-t border-[#555555]">
        
        <div class="py-[25px] px-[63px]">
            <p class="text-[11px] text-[#303030]">
                © {{ date('Y') }} SMK Kristen Immanuel Pontianak
            </p>
        </div>

    </div>

</footer>