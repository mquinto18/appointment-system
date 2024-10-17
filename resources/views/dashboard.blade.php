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
            <h1 class='font-bold text-[40px]'>{{ $totalAppointment }}</h1>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Completed</h1>
                <i class="fa-solid fa-check-to-slot text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalCompleted }}</h1>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Earning</h1>
                <i class="fa-solid fa-peso-sign text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalAmount }}</h1>
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
                        <th class="py-3 px-4 border-b">Visit Type</th>
                        <th class="py-3 px-4 border-b">Doctor</th>
                        <th class="py-3 px-4 border-b">Appointment Date</th>
                        <th class="py-3 px-4 border-b">Appointment Time</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Actions</th>
                        
                    </tr>
            </thead>
            <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td class="py-3 px-4 border-b">{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->doctor }}</td>
                            <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                            <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td class="py-3 px-4 border-b">
                                <div class="font-medium flex text-[12px] justify-center items-center gap-1 border-[1px] px-2 rounded-full text-center 
                                    @if($appointment->status === 'pending') bg-orange-100 border-orange-700 
                                    @elseif($appointment->status === 'approved') bg-green-100 border-green-700 
                                    @elseif($appointment->status === 'rejected') bg-red-100 border-red-700 
                                    @elseif($appointment->status === 'completed') bg-blue-100 border-blue-700 @endif">
                                    <i class="fa-solid fa-circle fa-2xs" 
                                        @if($appointment->status === 'pending') style="color: #c05621" 
                                        @elseif($appointment->status === 'approved') style="color: #38a169" 
                                        @elseif($appointment->status === 'rejected') style="color: #e53e3e" 
                                        @elseif($appointment->status === 'completed') style="color: #3182ce" @endif></i>
                                    {{ strtoupper($appointment->status) }}
                                </div>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <!-- Approve Action -->
                               <div class='flex gap-2'>
                               <form action="{{ route('appointments.approve', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative group cursor-pointer" 
                                        @if($appointment->status === 'approved' || $appointment->status === 'completed') disabled @endif>
                                        <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                                            @if($appointment->status === 'approved' || $appointment->status === 'completed') cursor-not-allowed opacity-50 @endif'>
                                            <i class="fa-solid fa-thumbs-up" style="color: #3bce54;"></i>
                                        </div>
                                    </button>
                                </form>
                                
                                <!-- Complete Action -->
                                <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative group cursor-pointer" 
                                        @if($appointment->status === 'completed') disabled @endif>
                                        <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                                            @if($appointment->status === 'completed') cursor-not-allowed opacity-50 @endif'>
                                            <i class="fa-solid fa-check-to-slot" style="color: #0074cb;"></i>
                                        </div>
                                    </button>
                                </form>

                                <!-- Reject Action -->
                                <form action="{{ route('appointments.reject', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative group cursor-pointer" 
                                        @if($appointment->status === 'rejected' || $appointment->status === 'completed') disabled @endif>
                                        <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                                            @if($appointment->status === 'rejected' || $appointment->status === 'completed') cursor-not-allowed opacity-50 @endif'>
                                            <i class="fa-solid fa-thumbs-down" style="color: #d02525;"></i>
                                        </div>
                                    </button>
                                </form>
                               </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection