@extends('layouts.app')

@section('title', 'Admin')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Appointments</h1>
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
            <div class='flex justify-between items-centermb-4'>
                <div>
                    <form method="GET" action="{{ route('appointment') }}">
                        <select name="records_per_page" class="border border-gray-300 p-2 rounded" onchange="this.form.submit()">
                            <option value="5" {{ request('records_per_page') == 5 ? 'selected' : '' }}>5 records per page</option>
                            <option value="10" {{ request('records_per_page') == 10 ? 'selected' : '' }}>10 records per page</option>
                        </select>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Search form -->
                    <form method="GET" action="{{ route('appointment') }}">
                        <input type="text" name="search" value="{{ request('search') }}" class="border border-gray-300 p-2 rounded" placeholder="Search by patient, doctor or visit type">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                    <a href="{{ route('appointment') }}"  class="bg-gray-600 px-4 py-2 rounded"><i class="fa-solid fa-rotate" style="color: #ffffff;"></i></a>
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
                        <td class="py-3 px-4 border-b">{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->doctor }}</td>
                        <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                        <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                        <td class="py-3 px-4 border-b ">
                            <!-- Status Badge -->
                            <div class="font-medium flex text-[12px] justify-center items-center gap-1 border-[1px] px-2 rounded-full text-center 
        @if($appointment->status === 'pending') bg-orange-100 border-orange-700 
        @elseif($appointment->status === 'approved') bg-green-100 border-green-700 
        @elseif($appointment->status === 'rejected') bg-red-100 border-red-700 
        @elseif($appointment->status === 'completed') bg-blue-100 border-blue-700 @endif">
                                <i class="fa-solid fa-circle fa-2xs"
                                    @if($appointment->status === 'pending') style="color: #c05621"
                                    @elseif($appointment->status === 'approved') style="color: #38a169"
                                    @elseif($appointment->status === 'rejected') style="color: #e53e3e"
                                    @elseif($appointment->status === 'completed') style="color: #3182ce" @endif>
                                </i>
                                {{ strtoupper($appointment->status) }}
                            </div>

                            <!-- Follow-up Badge (Only if follow_up == 1) -->
                            @if($appointment->follow_up == 1)
                            <div class="font-medium flex text-[12px] mt-2 justify-center items-center gap-1 border-[1px] px-2 rounded-full text-center 
    bg-yellow-100 border-yellow-600">
                                Follow-up
                            </div>
                            @endif
                        </td>

                        <td class="py-3 px-4 border-b">
                            <!-- Approve Action -->
                            <div class='flex gap-2'>
                                <form action="{{ route('appointments.approve', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative group cursor-pointer"
                                        @if($appointment->status === 'approved' || $appointment->status === 'completed') disabled @endif>
                                        <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                    @if($appointment->status === ' approved' || $appointment->status === 'completed') cursor-not-allowed opacity-50 @endif'>
                                            <i class="fa-solid fa-thumbs-up" style="color: #3bce54;"></i>
                                        </div>
                                        <!-- Tooltip for Approve -->
                                        <span class="absolute bottom-full mb-2 hidden text-xs text-white bg-gray-800 p-1 rounded group-hover:block">
                                            Approve
                                        </span>
                                    </button>
                                </form>

                                <!-- Complete Action -->
                                <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative group cursor-pointer"
                                        @if($appointment->status === 'completed') disabled @endif>
                                        <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                    @if($appointment->status === ' completed') cursor-not-allowed opacity-50 @endif'>
                                            <i class="fa-solid fa-check-to-slot" style="color: #0074cb;"></i>
                                        </div>
                                        <!-- Tooltip for Complete -->
                                        <span class="absolute bottom-full mb-2 hidden text-xs text-white bg-gray-800 p-1 rounded group-hover:block">
                                            Complete
                                        </span>
                                    </button>
                                </form>

                                <!-- Reject Action -->
                                <button type="button" class="relative group cursor-pointer" onclick="toggleRescheduleModal(true)">
                                    <div class="bg-white py-1 px-2 border border-[#0074CB] rounded-md 
        @if($appointment->status === 'rejected' || $appointment->status === 'completed') cursor-not-allowed opacity-50 @endif"
                                        @if($appointment->status === 'rejected' || $appointment->status === 'completed') disabled @endif>
                                        <i class="fa-solid fa-thumbs-down" style="color: #d02525;"></i>
                                    </div>
                                    <!-- Tooltip for Reject -->
                                    <span class="absolute bottom-full mb-2 hidden text-xs text-white bg-gray-800 p-1 rounded group-hover:block">
                                        Reject
                                    </span>
                                </button>


                                <!-- Reschedule Modal -->
                                <div id="rescheduleModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                                    <div class="modal-dialog bg-white rounded-lg w-[90%] sm:w-[650px] shadow-lg">
                                        <div class="modal-content text-center p-6">
                                            <h5 class="text-[24px] font-bold mb-3">Reschedule Appointment</h5>
                                            <form id="rescheduleAppointmentForm" method="POST" action="{{ route('appointments.reject', $appointment->id) }}">
                                                @csrf
                                                <!-- Date and Time Input Fields -->
                                                <div class="flex justify-between mb-6 px-4 py-4">
                                                    <div class="w-[48%]">
                                                        <label for="appointment_date" class="block text-left text-sm font-semibold text-gray-500 mb-1">Date</label>
                                                        <input type="date" id="appointment_date" name="appointment_date" class="block w-full text-gray-600 font-medium bg-white rounded-md p-3 border border-gray-300 focus:outline-none">
                                                    </div>
                                                    <div class="w-[48%]">
                                                        <label for="appointment_time" class="block text-left text-sm font-semibold text-gray-500 mb-1">Time</label>
                                                        <input type="time" id="appointment_time" name="appointment_time" class="block w-full text-gray-600 font-medium bg-white rounded-md p-3 border border-gray-300 focus:outline-none">
                                                    </div>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="flex border-t border-gray-200">
                                                    <button type="button" class="w-1/2 py-3 bg-gray-300 font-semibold border-r border-gray-200 hover:bg-gray-400 rounded-bl-md" onclick="toggleRescheduleModal(false)">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-1/2 py-3 bg-[#0074CB] text-white font-semibold hover:bg-[#005ea6] rounded-br-md">
                                                        Confirm Reschedule
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>

                        <td class="cursor-pointer border-b pr-5 text-center">



                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('appointments.followUp', $appointment->id) }}">
                                    <button type="button" class="relative group cursor-pointer"
                                        @if($appointment->status !== 'completed') disabled @endif>
                                        <div class="bg-white py-1 px-2 border border-gray-300 shadow-md rounded-md 
            @if($appointment->status !== 'completed') cursor-not-allowed opacity-50 @endif">
                                            <i class="fa-solid fa-notes-medical"></i>
                                        </div>

                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-max mb-2 hidden text-xs text-white bg-gray-800 p-1 rounded group-hover:block">
                                            Follow-up check up
                                        </span>
                                    </button>
                                </a>


                                <!-- Ellipsis Icon -->
                                <i class="fa-solid fa-ellipsis-vertical" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>

                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu font-medium absolute right-0 z-10 hidden text-left bg-white shadow-lg rounded-lg w-40" aria-labelledby="dropdownMenuButton">
                                    <!-- Edit Option -->
                                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="block">
                                        <div class="px-4 py-2 flex items-center hover:bg-gray-100">
                                            <i class="fa-regular fa-pen-to-square mr-2 text-gray-600"></i>
                                            <span class="text-sm">Edit</span>
                                        </div>
                                    </a>
                                    <!-- View Option -->
                                    <a href="#" onclick="openViewModal({{ $appointment }})" class="block">
                                        <li class="px-4 py-2 flex items-center hover:bg-gray-100">
                                            <i class="fa-regular fa-eye mr-2 text-gray-600"></i>
                                            <span class="text-sm">View</span>
                                        </li>
                                    </a>
                                    <!-- Delete Option -->
                                    <div class="px-4 py-2 flex items-center hover:bg-gray-100">
                                        <form action="#" method="POST" class="flex items-center w-full" onsubmit="return false;">
                                            @csrf
                                            @method('DELETE')
                                            <i class="fa-regular fa-trash-can mr-2 text-gray-600"></i>
                                            <button type="button" onclick="openDeleteModal('{{ $appointment->first_name }} {{ $appointment->last_name }}', '{{ route('appointments.destroy', $appointment->id) }}')" class="text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </ul>
                            </div>
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
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="modal-body text-center mb-5 mx-4">
                <i class="fa-solid fa-triangle-exclamation text-[55px] my-4" style="color: #ff0000;"></i>
                <h5 class="modal-title mb-3 text-[25px] font-bold" id="deleteAdminModalLabel">Delete Appointment</h5>
                <p id="deleteAdminMessage">Are you sure you want to delete <strong></strong>? Once deleted, it cannot be recovered.</p>
            </div>
            <div class="p-0 m-0">
                <div class='flex w-full'>
                    <button type="button" class="btn btn-secondary w-1/2 p-3 m-0 border-0 rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteAdminForm" method="POST" action="" class="w-1/2 m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full p-3 m-0 border-0 rounded-0">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Transaction Number -->
                    <div class="col-md-4 mb-3">
                        <strong>Transaction Number:</strong>
                        <input type="text" class="form-control" id="viewTransactionNumber" readonly>
                    </div>

                    <!-- Patient Name -->
                    <div class="col-md-4 mb-3">
                        <strong>Patient Name:</strong>
                        <input type="text" class="form-control" id="viewPatientName" readonly>
                    </div>

                    <!-- Doctor -->
                    <div class="col-md-4 mb-3">
                        <strong>Doctor:</strong>
                        <input type="text" class="form-control" id="viewDoctor" readonly>
                    </div>

                    <!-- Appointment Date -->
                    <div class="col-md-4 mb-3">
                        <strong>Appointment Date:</strong>
                        <input type="text" class="form-control" id="viewAppointmentDate" readonly>
                    </div>

                    <!-- Appointment Time -->
                    <div class="col-md-4 mb-3">
                        <strong>Appointment Time:</strong>
                        <input type="text" class="form-control" id="viewAppointmentTime" readonly>
                    </div>

                    <!-- Visit Type -->
                    <div class="col-md-4 mb-3">
                        <strong>Visit Type:</strong>
                        <input type="text" class="form-control" id="viewVisitType" readonly>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <strong>Status:</strong>
                        <input type="text" class="form-control" id="viewStatus" readonly>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-12 mb-3">
                        <strong>Additional Information:</strong>
                        <textarea class="form-control" id="viewAdditionalInfo" rows="3" readonly></textarea>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-4 mb-3">
                        <strong>Date of Birth:</strong>
                        <input type="text" class="form-control" id="viewDateOfBirth" readonly>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-4 mb-3">
                        <strong>Gender:</strong>
                        <input type="text" class="form-control" id="viewGender" readonly>
                    </div>

                    <!-- Marital Status -->
                    <div class="col-md-4 mb-3">
                        <strong>Marital Status:</strong>
                        <input type="text" class="form-control" id="viewMaritalStatus" readonly>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-4 mb-3">
                        <strong>Contact Number:</strong>
                        <input type="text" class="form-control" id="viewContactNumber" readonly>
                    </div>

                    <!-- Email Address -->
                    <div class="col-md-4 mb-3">
                        <strong>Email Address:</strong>
                        <input type="text" class="form-control" id="viewEmailAddress" readonly>
                    </div>

                    <!-- Complete Address -->
                    <div class="col-md-4 mb-3">
                        <strong>Complete Address:</strong>
                        <input type="text" class="form-control" id="viewCompleteAddress" readonly>
                    </div>

                    <!-- Notes -->
                    <div class="col-md-12 mb-3">
                        <strong>Notes:</strong>
                        <textarea class="form-control" id="viewNotes" rows="3" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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
                                <option value="Medical Consultation">Medical Consultation</option>
                                <option value="Pediatric Consultation">Pediatric Consultation</option>
                                <option value="Pediatric Ears, Nose and Throat">Pediatric Ears, Nose and Throat</option>
                                <option value="Adult Ears, Nose and Throat">Adult Ears, Nose and Throat</option>
                                <option value="Minor Suturing">Minor Suturing</option>
                                <option value="Wound Dressing">Wound Dressing</option>
                            </select>
                        </div>

                        <!-- Additional Information -->
                        <div class="col-md-4 mb-3">
                            <label for="additional" class="form-label">Additional Information</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="additional" name="additional" value="Medical Certificate">
                                <label class="form-check-label" for="additional">
                                    Medical Certificate
                                </label>
                            </div>
                        </div>

                        <!-- Doctor -->
                        <div class="col-md-4 mb-3">
                            <label for="doctor" class="form-label">Doctor</label>
                            <select class="form-select" id="doctor" name="doctor" required>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
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
    <script>
        function toggleRescheduleModal(show) {
            const modal = document.getElementById("rescheduleModal");
            if (show) {
                modal.classList.remove("hidden");
            } else {
                modal.classList.add("hidden");
            }
        }

        function toggleRescheduleModal(show) {
            const modal = document.getElementById("rescheduleModal");
            if (show) {
                modal.classList.remove("hidden");
            } else {
                modal.classList.add("hidden");
            }
        }

        function openViewModal(appointment) {
            document.getElementById('viewTransactionNumber').value = appointment.transaction_number; // Set transaction number
            document.getElementById('viewPatientName').value = appointment.first_name + ' ' + appointment.last_name;
            document.getElementById('viewDoctor').value = appointment.doctor;
            document.getElementById('viewAppointmentDate').value = new Date(appointment.appointment_date).toLocaleDateString();
            document.getElementById('viewAppointmentTime').value = new Date('1970-01-01T' + appointment.appointment_time + 'Z').toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('viewVisitType').value = appointment.visit_type;
            document.getElementById('viewStatus').value = appointment.status;
            document.getElementById('viewAdditionalInfo').value = appointment.additional || 'N/A';
            document.getElementById('viewDateOfBirth').value = new Date(appointment.date_of_birth).toLocaleDateString();
            document.getElementById('viewGender').value = appointment.gender;
            document.getElementById('viewMaritalStatus').value = appointment.marital_status;
            document.getElementById('viewContactNumber').value = appointment.contact_number;
            document.getElementById('viewEmailAddress').value = appointment.email_address;
            document.getElementById('viewCompleteAddress').value = appointment.complete_address;
            document.getElementById('viewNotes').value = appointment.notes || 'N/A';

            var myModal = new bootstrap.Modal(document.getElementById('viewAppointmentModal'), {
                keyboard: false
            });
            myModal.show();
        }
    </script>
    <script>
        function openDeleteModal(name, url) {
            // Set the confirmation message
            document.getElementById('deleteAdminMessage').innerHTML = 'Are you sure you want to delete <strong>' + name + '</strong>? Once deleted, it cannot be recovered.';
            // Set the form action to the correct URL
            document.getElementById('deleteAdminForm').action = url;
            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('deleteAdminModal'), {
                keyboard: false
            });
            myModal.show();
        }
    </script>

</div>


@endsection