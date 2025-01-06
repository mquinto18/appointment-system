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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class='bg bg-gray-100'>
    <div class='absolute right-0 p-5'>
        <div x-data="{show: false, notifyShow: false}" x-on:click.away="show = false; notifyShow = false" class="ml-3 relative">
            <div class="flex justify-center items-center gap-3">

                <!-- Dropdown Notification -->
                <div x-data="{ notifyShow: false }" class="relative inline-block ml-3 group">
                    <button x-on:click="notifyShow = !notifyShow" class="bg-white shadow-md px-3 py-2 rounded focus:outline-none">
                        <i class="fa-solid fa-bell text-xl"></i>
                    </button>
                    <!-- Notifications dropdown -->
                    <div x-show="notifyShow" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        x-cloak class="absolute right-0 mt-2 z-10 w-72 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" tabindex="-1">
                        <div class="py-2 px-4 text-sm text-gray-700">
                            <a href="{{ route('appointments.pending') }}" class="flex justify-between items-center border-b py-2 border-b-gray-300">
                                <div class="flex justify-center items-center gap-3">
                                    <i class="fa-regular fa-circle-user text-[32px]" style="color: #0074cb;"></i>
                                    <div>
                                        <span class="font-bold text-[15px]">Jan, New appointment scheduled</span>
                                        <br><span>October 17, 2024 at 9:00 AM</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="absolute top-[-5px] right-[-5px] bg-red-600 rounded-full h-5 w-5 flex items-center justify-center">
                        <span class="text-white text-xs">20</span>
                    </div>

                </div>

                <button x-on:click="show = !show" type="button" class="inline-flex items-center px-3 py-1 bg-white shadow-md text-sm leading-4 font-medium rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <div class='flex justify-center items-center gap-3'>
                        <div>{{ Auth::user()->name }}</div>
                        <div class='border border-[#5EA7E6] text-[#5EA7E6] rounded-full h-5 w-5 flex justify-center items-center p-[15px]'>
                            {{ strtoupper(substr(explode(' ', Auth::user()->name)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }} <!-- Combined Initials -->
                        </div>
                    </div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Auth User Dropdown -->
            <div x-show="show" class="origin-top-right absolute right-0 mt-2 w-60 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <div class='border-b py-4'>
                    <div class='flex justify-center'>
                        <div class='border text-center border-[#5EA7E6] text-[#5EA7E6] rounded-full h-14 text-[20px] w-14 flex justify-center items-center p-[15px]'>
                            {{ strtoupper(substr(explode(' ', Auth::user()->name)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }} <!-- Combined Initials -->
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

                <div class='py-2'>
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
    </div>


    <div class="flex flex-row">
        <div class="flex flex-col w-64 h-screen fixed overflow-y-auto bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700">
            <div class="sidebar text-center bg-white">
                <div class="text-gray-100 text-xl">
                    <div class="flex justify-center items-center gap-3 py-5 px-3 leading-4">
                        <img src="{{ asset('images/logo.png') }}" alt="" class='w-[65px]'>
                        <h1 class='text-black text-[15px] italic font-medium'>St. Benedict Medical Clinic & Pharmacy</h1>
                    </div>
                    <div class="my-2 bg-gray-200 h-[1px]"></div>
                </div>

                <div class='mx-2'>
                    <!-- Home Link -->
                    <a href="/admin/home" class="group nav-link">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8] {{ Request::is('admin/home') ? 'bg-[#0074C8] text-white' : '' }}">
                            <i class="bi bi-house-door-fill"></i>
                            <span class="text-[15px] ml-4 font-bold">Home</span>
                        </div>
                    </a>

                    <!-- System User Link with Dropdown -->
                    <div class="relative">
                        <a href="javascript:void(0);" class="group nav-link {{ Request::routeIs('admin', 'user', 'doctor', 'cashier') ? 'bg-[#0074C8] text-white' : '' }}" onclick="toggleDropdown('system-user-dropdown');">
                            <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8] {{ Request::is('admin/system-user/*') ? 'bg-[#0074C8] text-white' : '' }}">
                                <i class="fa-solid fa-user"></i>
                                <span class="text-[15px] ml-4 font-bold">System User</span>
                                <i class="ml-auto bi bi-chevron-down"></i>
                            </div>
                        </a>
                        <!-- Dropdown for System User (open by default if a child link is active) -->
                        <div id="system-user-dropdown" class="relative w-full text-left rounded-md mt-1 space-y-1 px-2 py-1 {{ Request::is('admin/system-user/*') ? '' : 'hidden' }}">
                            <a href="{{ route('admin') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('admin') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>Admin</li>
                            </a>
                            <a href="{{ route('user') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('user') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>User</li>
                            </a>
                            <a href="{{ route('doctor') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('doctor') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>Doctor</li> 
                            </a>
                            <a href="{{ route('cashier') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('cashier') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>cashier</li> 
                            </a>
                        </div>
                    </div>

                    <!-- Appointment Link with Dropdown -->
                    <div class="relative">
                        <a href="javascript:void(0);" class="group nav-link {{ Request::routeIs('appointment') ? 'bg-[#0074C8] text-white' : '' }}" onclick="toggleDropdown('appointment-dropdown');">
                            <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8] {{ Request::is('admin/appointments/*') ? 'bg-[#0074C8] text-white' : '' }}">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span class="text-[15px] ml-4 font-bold">Appointment</span>
                                <i class="ml-auto bi bi-chevron-down"></i>
                            </div>
                        </a>
                        <!-- Dropdown for Appointment (open by default if a child link is active) -->
                        <div id="appointment-dropdown" class="relative w-full text-left rounded-md mt-1 space-y-1 px-2 py-1 {{ Request::is('admin/appointments/*') ? '' : 'hidden' }}">
                            <a href="{{ route('appointment') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('appointment') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>Total Appointment</li>
                            </a>
                        </div>
                    </div>

                    <!-- Other Navigation Links -->
                    <!-- <a href="{{ route('prescription') }}" class="group nav-link {{ Request::routeIs('prescription') ? 'bg-[#0074C8] text-white' : '' }}">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8]">
                            <i class="fa-solid fa-prescription"></i>
                            <span class="text-[15px] ml-4 font-bold">Prescription</span>
                        </div>
                    </a> -->

                    <a href="{{ route('invoice') }}" class="group nav-link {{ Request::routeIs('invoice') ? 'bg-[#0074C8] text-white' : '' }}">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8]">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span class="text-[15px] ml-4 font-bold">Invoice</span>
                        </div>
                    </a>

                    <a href="{{ route('medicalcert') }}" class="group nav-link {{ Request::routeIs('medicalcert') ? 'bg-[#0074C8] text-white' : '' }}">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8]">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span class="text-[15px] ml-4 font-bold">Medical Certificate</span>
                        </div>
                    </a>

                    <!-- <a href="{{ route('reports') }}" class="group nav-link {{ Request::routeIs('reports') ? 'bg-[#0074C8] text-white' : '' }}">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8]">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span class="text-[15px] ml-4 font-bold">Reports</span>
                        </div>
                    </a> -->

                    <!-- Profile Link with Dropdown -->
                    <div class="relative">
                        <a href="javascript:void(0);" class="group nav-link {{ Request::routeIs('profile.settings', 'security.settings') ? 'bg-[#0074C8] text-white' : '' }}" onclick="toggleDropdown('profile-dropdown');">
                            <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8] {{ Request::is('admin/profile/*') ? 'bg-[#0074C8] text-white' : '' }}">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span class="text-[15px] ml-4 font-bold">Account Settings</span>
                                <i class="ml-auto bi bi-chevron-down"></i>
                            </div>
                        </a>
                        <!-- Dropdown for Account Settings -->
                        <div id="profile-dropdown" class="hidden relative w-full text-left rounded-md mt-1 space-y-1 px-2 py-1">
                            <a href="{{ route('profile.settings') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('profile.settings') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>Profile Settings</li>
                            </a>
                            <a href="{{ route('security.settings') }}" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white {{ Request::routeIs('security.settings') ? 'bg-[#0074C8] text-white' : '' }}">
                                <li>Security Settings</li>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Sign out -->
                <div class='mx-2 my-2 rounded-md py-2 text-center bg-[#0074C8] cursor-pointer text-white' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    Sign out
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col w-full h-screen ml-64 px-4 py-8">
            <div>@yield('contents')</div>
        </div>
    </div>


    <script>
        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }
        // Function to handle active link styling
        function setActive(link) {
            document.querySelectorAll('.nav-link').forEach(item => {
                item.classList.remove('active');
                item.querySelector('div').classList.remove('', 'text-white');
            });

            // Add active class to the clicked link
            link.classList.add('active');
            link.querySelector('div').classList.add('', 'text-white');

            // Store the active link's href in localStorage
            localStorage.setItem('activeLink', link.getAttribute('href'));
        }

        // Function to toggle dropdown visibility
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }

        // Set active link based on the current URL or localStorage
        function setActiveLinkOnLoad() {
            const currentUrl = window.location.pathname;
            const activeLinkHref = localStorage.getItem('activeLink');

            // Check if there's an active link stored in localStorage
            if (activeLinkHref) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (linkHref === activeLinkHref) {
                        setActive(link);
                    }
                });
            } else {
                // If not, check for the current URL
                document.querySelectorAll('.nav-link').forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (linkHref === currentUrl) {
                        setActive(link);
                    }
                });
            }
        }

        // Initialize active link on load
        window.onload = setActiveLinkOnLoad;

        // Add click event listeners to nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                setActive(this);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <x-notify::notify />
    @notifyJs

</body>

</html>