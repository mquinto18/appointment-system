@extends('layouts.app')

@section('title', 'Admin')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Administrator</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>   

<div class='mx-10 -mt-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>All Appointment | {{ $totalAppointments }}</span>
        <div class='bg-white px-3 py-2 rounded-md cursor-pointer' data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="fa-solid fa-plus" style="color: #0074CB;"></i>
            <a href="#" class='font-medium no-underline text-black'>Add appointment</a>
        </div>
    </div>

    <div class='bg-white w-full rounded-lg shadow-md p-8'>
    <div class="overflow-x-auto">
       
        @include('appointment.navigation')
        <div class='flex justify-between items-center mb-4'>
            <div>
                <!-- Records per page dropdown (optional, not implemented in the controller yet) -->
                <select name="records_per_page" class="border border-gray-300 p-2 rounded">
                    <option value="5">5 records per page</option>
                    <option value="10">10 records per page</option>
                </select>
            </div>
            <div class="flex items-center">
                <!-- Search form -->
                <form method="GET" action="{{ route('appointment') }}">
                    <input type="text" name="search" value="{{ request('search') }}" class="border border-gray-300 p-2 rounded" placeholder="Search by patient, doctor or visit type">
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Search</button>
                </form>
            </div>
        </div>

        <!-- If no appointments are found, display a message -->
        @if($appointments->isEmpty())
            <div class="text-center text-gray-500 mt-4">
                No appointments found for the search query "{{ request('search') }}".
            </div>
        @else
            <table id='myTable' class="min-w-full bg-white border mt-3">
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
                        <th class="py-3 px-4 border-b"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4 border-b">{{ $appointment->id }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->doctor }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->appointment_date }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->appointment_time }}</td>
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
                            <td>
                                <i class="fa-solid fa-ellipsis-vertical"></i>   
                            </td>   
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="mt-4">
                {{ $appointments->appends(['search' => request('search')])->links() }}
            </div>
        @endif
    </div>
</div>


</div>

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('appointment.save') }}">
                    @csrf


                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-4 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-4 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-4 mb-3">
                            <label for="dateOfBirth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth" required>
                        </div>

                        <!-- Appointment Date -->
                        <div class="col-md-4 mb-3">
                            <label for="appointmentDate" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="appointment_date" required>
                        </div>

                        <!-- Appointment Time -->
                        <div class="col-md-4 mb-3">
                            <label for="appointmentTime" class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" id="appointmentTime" name="appointment_time" required>
                        </div>

                        <!-- Visit Type -->
                        <div class="col-md-4 mb-3">
                            <label for="visitType" class="form-label">Visit Type</label>
                            <select class="form-select" id="visitType" name="visit_type" required>
                                <option value="Consultation">Consultation</option>
                                <option value="Follow-up">Follow-up</option>
                            </select>
                        </div>

                        <!-- Additional Information -->
                        <div class="col-md-4 mb-3">
                            <label for="additional" class="form-label">Additional Information</label>
                            <input type="text" class="form-control" id="additional" name="additional">
                        </div>

                        <!-- Doctor -->
                        <div class="col-md-4 mb-3">
                            <label for="doctor" class="form-label">Doctor</label>
                            <select class="form-select" id="doctor" name="doctor" required>
                                <option value="Dr. Jane Smith">Dr. Jane Smith</option>
                                <option value="Dr. John Doe">Dr. John Doe</option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div class="col-md-4 mb-3">
                            <label for="maritalStatus" class="form-label">Marital Status</label>
                            <select class="form-select" id="maritalStatus" name="marital_status" required>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                            </select>
                        </div>

                        <!-- Contact Number -->
                        <div class="col-md-4 mb-3">
                            <label for="contactNumber" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-4 mb-3">
                            <label for="emailAddress" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="emailAddress" name="email_address" required>
                        </div>

                        <!-- Complete Address -->
                        <div class="col-md-4 mb-3">
                            <label for="completeAddress" class="form-label">Complete Address</label>
                            <input type="text" class="form-control" id="completeAddress" name="complete_address" required>
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Appointment</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection