<!DOCTYPE html>
<html lang="en">

<head>
    @notifyCss
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    html {
    scroll-behavior: smooth;
}
</style>

<body class="bg-gray-100">
    <div class=''>
        <nav class="bg-[#0074C8] ">
            <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex justify-center items-center gap-3 py-5 px-3 leading-4">
                            <img src="{{ asset('images/logo.png') }}" alt="" class='w-[50px]'>
                            <h1 class='text-white text-[14px] italic font-medium'>
                                St. Benedict Medical <br> Clinic & Pharmacy
                            </h1>
                        </div>
                    </div>

                    <!-- Mobile Hamburger Button -->
                    <div class="md:hidden flex items-center">
                        <button id="hamburgerButton" class="text-white focus:outline-none">
                            <i class="bi bi-list text-2xl"></i> <!-- Hamburger Icon -->
                        </button>
                    </div>

                    <div id="navbar" class="hidden space-x-4">
                        <a href="{{ url('/') }}" class="text-white px-3 py-2 rounded-md text-sm">Home</a>
                        <a href="{{ route('appointment.aboutMore') }}" class="text-white hover:text-white px-3 py-2 rounded-md text-sm">About Us</a>
                        <a href="#" class="text-white hover:text-white px-3 py-2 rounded-md text-sm">Contact Us</a>
                    </div>

                    <div class="hidden md:block">
                        <div class="flex-grow flex justify-center ">
                            <div class="ml-10 flex items-baseline space-x-4 font-medium">
                                <a href="{{ url('/') }}" class="text-white px-3 py-2 rounded-md text-sm">Home</a>
                                <a href="{{ route('appointment.aboutMore') }}" class="text-white hover:text-white px-3 py-2 rounded-md text-sm">About Us</a>
                                <a href="{{ url('/#contact-section') }}" class="text-white hover:text-white px-3 py-2 rounded-md text-sm">Contact Us</a>
                            </div>
                        </div>
                    </div>


                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @if (Route::has('login'))
                            @auth
                            <!-- Dropdown Appintment -->
                            <!-- Dropdown Notification -->
                            <div class="relative group">
                                <a href="{{ route('appointments.booked') }}">
                                    <button class="bg-white shadow-md px-3 py-2 rounded focus:outline-none">
                                        <i class="fa-solid fa-calendar-check text-xl"></i>
                                    </button>
                                </a>
                                <!-- Popup on hover (below the button) -->
                                <div class="absolute top-full mt-2 hidden group-hover:block bg-black text-white text-xs rounded py-1 px-3 z-10">
                                    Appointments
                                    <div class="absolute left-1/2 transform -translate-x-1/2 -top-2 border-8 border-transparent border-b-black"></div>
                                </div>
                            </div>









                            <div x-data="{show: false}" x-on:click.away="show = false" class="ml-3 relative">
                                <div>
                                    <button x-on:click="show = !show" type="button" class="inline-flex items-center px-3 py-1 bg-white shadow-md text-sm leading-4 font-medium rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <div class='flex justify-center items-center gap-3'>
                                            <div>{{ Auth::user()->name }}</div>
                                            <div class='border border-[#5EA7E6] text-[#5EA7E6] rounded-full h-5 w-5 flex justify-center items-center p-[15px]'>
                                                {{ strtoupper(substr(explode(' ', Auth::user()->name)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                                <div x-show="show" class="origin-top-right absolute z-10 right-0 mt-2 w-60 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <div class='border-b py-4'>
                                        <div class='flex justify-center'>
                                            <div class='border text-center border-[#5EA7E6] text-[#5EA7E6] rounded-full h-14 text-[20px] w-14 flex justify-center items-center p-[15px]'>
                                                {{ strtoupper(substr(explode(' ', Auth::user()->name)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class='text-center text-[18px] font-medium'>
                                                {{ Auth::user()->name }}
                                            </div>
                                            <div class='text-center text-[14px]'>
                                                {{ Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class='py-3'>
                                        <a href="{{ route('userProfile.settings') }}" class='flex flex-row gap-2 items-center py-2 px-5 cursor-pointer hover:bg-[#bbd5e9]'>
                                            <i class="fa-solid fa-user"></i>
                                            <span>My Profile</span>
                                        </a>
                                        <a href="{{ route('userSecurity.settings') }}" class='flex flex-row gap-2 items-center py-2 px-5 cursor-pointer hover:bg-[#bbd5e9]'>
                                            <i class="fa-solid fa-gear"></i>
                                            <span>Account Settings</span>
                                        </a>
                                        <div class='mx-5 my-2 rounded-md py-1 text-center bg-[#0074C8] text-white'>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Sign out
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class='bg-white py-2 px-5 rounded-md flex justify-center items-center gap-3'>
                                <a href="{{ route('login') }}" class="text-black text-[12px] font-semibold">LOG IN</a>
                                <div class='w-[2px] h-3 bg-[#0074C8]'></div>
                                <a href="{{ route('register') }}" class="text-black text-[12px] font-semibold">SIGN UP</a>
                            </div>
                            @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>


        <div class="">
            <div>@yield('contents')</div>
            @yield('scripts')
        </div>
        </main>
    </div>

    <x-notify::notify />
    @notifyJs
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.getElementById("hamburgerButton").addEventListener("click", function() {
            var navbar = document.getElementById("navbar");

            // Toggle the 'hidden' class to show or hide the navbar
            navbar.classList.toggle("hidden");
        });
        l4
        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.hash) {
                let target = document.querySelector(window.location.hash);
                if (target) {
                    setTimeout(() => {
                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start"
                        });
                    }, 100); // Small delay to ensure rendering
                }
            }
        });
    </script>
</body>

</html>