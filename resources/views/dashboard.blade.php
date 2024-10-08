@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('contents')
<div class='flex justify-between items-center'>
    <div>
        <h1 class='font-medium text-2xl ml-3'>
            Dashboard
        </h1>
    </div>
   
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-20'>
    <div class='grid grid-cols-4 gap-3'>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Users</h1>
                <i class="fa-solid fa-user text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalUsers }}</h1> <!-- Display total users here -->

        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Appointments</h1>
                <i class="fa-regular fa-calendar-days text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>57</h1>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Doctors</h1>
                <i class="fa-solid fa-user-doctor text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>57</h1>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Completed</h1>
                <i class="fa-solid fa-check-to-slot text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>57</h1>
        </div>
        
    </div>

    <div class='bg-white w-full mt-5 px-4 rounded-lg'>
    <div class='font-medium border-b py-3'>
        Appointment Today
    </div>

    <div>
        <table class="min-w-full bg-white border mt-3">
            <thead>
                <tr class="text-left">
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Patient Name</th>
                    <th class="py-3 px-4 border-b">Age</th>
                    <th class="py-3 px-4 border-b">Email</th>
                    <th class="py-3 px-4 border-b">Visit Type</th>
                    <th class="py-3 px-4 border-b">Consulting Doctor</th>
                    <th class="py-3 px-4 border-b">Date</th>
                    <th class="py-3 px-4 border-b">Time</th>
                    <th class="py-3 px-4 border-b">Status</th>
                    <th class="py-3 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b">1</td>
                    <td class="py-3 px-4 border-b">John Doe</td>
                    <td class="py-3 px-4 border-b">30</td>
                    <td class="py-3 px-4 border-b">john@example.com</td>
                    <td class="py-3 px-4 border-b">Check-up</td>
                    <td class="py-3 px-4 border-b">Dr. Smith</td>
                    <td class="py-3 px-4 border-b">2024-10-05</td>
                    <td class="py-3 px-4 border-b">10:00 AM</td>
                    <td class="py-3 px-4 border-b text-yellow-500 font-medium">Pending</td>
                    <td class="py-3 px-4 border-b flex gap-2">
                        <div class='relative group'>
                            <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md'>
                                <a href="#" class="text-blue-600">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                            <!-- Tooltip for 'View' -->
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                View
                            </div>
                        </div>
                        
                        <div class='relative group'>
                            <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md'>
                                <a href="#" class="text-blue-600">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </div>
                            <!-- Tooltip for 'Edit' -->
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                Edit
                            </div>
                        </div>
                        
                        <div class='relative group'>
                            <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md'>
                                <a href="#" class="text-blue-600" onclick="event.preventDefault(); confirm('Are you sure you want to delete this appointment?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                            <!-- Tooltip for 'Delete' -->
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                Delete
                            </div>
                        </div>
                    </td>
                </tr>
               
                
                
            </tbody>
        </table>
    </div>
</div>


   
</div>


@endsection