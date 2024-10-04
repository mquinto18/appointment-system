<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class='bg bg-gray-100'>

    <div class="flex flex-row">
        <div class="flex flex-col w-64 h-screen fixed overflow-y-auto bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700">
            <div class="sidebar text-center bg-white">
                <div class="text-gray-100 text-xl">
                    <div class="flex justify-center items-center gap-3 py-5 px-5 leading-4" >
                        <img src="{{ asset('images/logo.png') }}" alt="" class='w-[65px]'>
                        <h1 class='text-black text-[15px] italic font-medium'>St. Benedict Medical Clinic & Pharmacy</h1>
                    </div>
                    <div class="my-2 bg-gray-200 h-[1px]"></div>
                </div>

                <div class='mx-4'>
                    <a href="/admin/home" class="group nav-link active" onclick="setActive(this)">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-[#0074C8] text-white">
                            <i class="bi bi-house-door-fill"></i>
                            <span class="text-[15px] ml-4 font-bold">Home</span>
                        </div>
                    </a>

                    <!-- System User Link with Dropdown -->
                    <div class="relative">
                        <a href="javascript:void(0);" class="group nav-link" onclick="toggleDropdown('system-user-dropdown')">
                            <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8] hover:text-white">
                                <i class="fa-solid fa-user"></i>
                                <span class="text-[15px] ml-4 font-bold">System User</span>
                                <i class="ml-auto bi bi-chevron-down"></i>
                            </div>
                        </a>
                        <!-- Dropdown for System User -->
                        <div id="system-user-dropdown" class="hidden relative w-full text-left rounded-md mt-1 space-y-1 px-2 py-1">
                            <a href="/admin/user/admin" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white"><li>Admin</li></a>
                            <a href="/admin/user/user" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white"><li>User</li></a>
                            <a href="/admin/user/doctor" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white"><li>Doctor</li></a>
                        </div>
                    </div>

                    <!-- Appointment Link with Dropdown -->
                    <div class="relative">
                        <a href="javascript:void(0);" class="group nav-link" onclick="toggleDropdown('appointment-dropdown')">
                            <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8] hover:text-white">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span class="text-[15px] ml-4 font-bold">Appointment</span>
                                <i class="ml-auto bi bi-chevron-down"></i>
                            </div>
                        </a>
                        <!-- Dropdown for Appointment -->
                        <div id="appointment-dropdown" class="hidden relative w-full text-left rounded-md mt-1 space-y-1 px-2 py-1">
                            <a href="/admin/appointment/emergency" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white"><li>Emergency</li></a>
                            <a href="/admin/appointment/total" class="block px-4 py-2 rounded hover:bg-[#0074C8] hover:text-white"><li>Total Appointment</li></a>
                        </div>
                    </div>

                    <!-- Other Navigation Links (if any) -->
                    <a href="/admin/reports" class="group nav-link">
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#0074C8]">
                            <i class="fa-solid fa-chart-line"></i>
                            <span class="text-[15px] ml-4 font-bold">Reports</span>
                        </div>
                    </a>
                </div>

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

        <!-- Main Content -->
        <div class="flex flex-col w-full h-screen ml-64 px-4 py-8 mt-10">
            <div>@yield('contents')</div>
        </div>  
    </div>

    <script>
    // Function to handle active link styling
    function setActive(link) {
        document.querySelectorAll('.nav-link').forEach(item => {
            item.classList.remove('active');
            item.querySelector('div').classList.remove('bg-blue-600', 'text-white');
        });

        link.classList.add('active');
        link.querySelector('div').classList.add('bg-blue-600', 'text-white');
    }

    // Function to toggle dropdown visibility
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }
    </script>
</body>
</html>
