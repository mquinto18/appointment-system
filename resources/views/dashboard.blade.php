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
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-600">Edit</a> |
                        <a href="#" class="text-red-600" onclick="event.preventDefault(); confirm('Are you sure you want to delete this appointment?');">Delete</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b">2</td>
                    <td class="py-3 px-4 border-b">Jane Smith</td>
                    <td class="py-3 px-4 border-b">28</td>
                    <td class="py-3 px-4 border-b">jane@example.com</td>
                    <td class="py-3 px-4 border-b">Follow-up</td>
                    <td class="py-3 px-4 border-b">Dr. Jones</td>
                    <td class="py-3 px-4 border-b">2024-10-05</td>
                    <td class="py-3 px-4 border-b">11:30 AM</td>
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-600">Edit</a> |
                        <a href="#" class="text-red-600" onclick="event.preventDefault(); confirm('Are you sure you want to delete this appointment?');">Delete</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b">3</td>
                    <td class="py-3 px-4 border-b">Michael Johnson</td>
                    <td class="py-3 px-4 border-b">45</td>
                    <td class="py-3 px-4 border-b">michael@example.com</td>
                    <td class="py-3 px-4 border-b">Initial Consultation</td>
                    <td class="py-3 px-4 border-b">Dr. Brown</td>
                    <td class="py-3 px-4 border-b">2024-10-05</td>
                    <td class="py-3 px-4 border-b">2:00 PM</td>
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-600">Edit</a> |
                        <a href="#" class="text-red-600" onclick="event.preventDefault(); confirm('Are you sure you want to delete this appointment?');">Delete</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b">4</td>
                    <td class="py-3 px-4 border-b">Emily Davis</td>
                    <td class="py-3 px-4 border-b">50</td>
                    <td class="py-3 px-4 border-b">emily@example.com</td>
                    <td class="py-3 px-4 border-b">Routine Check-up</td>
                    <td class="py-3 px-4 border-b">Dr. Wilson</td>
                    <td class="py-3 px-4 border-b">2024-10-05</td>
                    <td class="py-3 px-4 border-b">3:15 PM</td>
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-600">Edit</a> |
                        <a href="#" class="text-red-600" onclick="event.preventDefault(); confirm('Are you sure you want to delete this appointment?');">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


   
</div>


@endsection