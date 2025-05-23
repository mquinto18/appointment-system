@extends('layouts.cashier')

@section('title', 'Cashier')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Medical Billing Invoice</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>All Appointment | {{ $totalAppointments }}</span>
    </div>

    <div class='bg-white w-full rounded-lg shadow-md p-8'>
        <div class="overflow-x-auto">

            <div class='flex justify-between items-center mb-4'>
                <div>
                    <form method="GET" action="{{ route('cashier.invoice') }}">
                        <select name="records_per_page" class="border border-gray-300 p-2 rounded" onchange="this.form.submit()">
                            <option value="5" {{ request('records_per_page') == 5 ? 'selected' : '' }}>5 records per page</option>
                            <option value="10" {{ request('records_per_page') == 10 ? 'selected' : '' }}>10 records per page</option>
                        </select>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Search form -->
                    <form method="GET" action="{{ route('cashier.invoice') }}">
                        <input type="text" name="search" value="{{ request('search') }}" class="border border-gray-300 p-2 rounded" placeholder="Search ">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                    <a href="{{ route('cashier.invoice') }}" class="bg-gray-600 px-4 py-2 rounded"><i class="fa-solid fa-rotate" style="color: #ffffff;"></i></a>
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
                        <!-- <th class="py-3 px-4 border-b">Appointment Date</th>
                        <th class="py-3 px-4 border-b">Appointment Time</th> -->
                        <th class="py-3 px-4 border-b">Payment Status</th>
                        <th class="py-3 px-4 border-b">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border-b">{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->doctor }}</td>
                        <!-- <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                        <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td> -->
                        <td class="py-3 border-b flex justify-center">
                            <!-- <div class="font-medium flex text-[12px] justify-center items-center gap-1 border-[1px] px-2 rounded-full text-center 
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
                            </div> -->
                            <div class="font-medium flex text-[14px] justify-center  items-center gap-1 border-[1px] px-2 rounded-full py-2 text-center w-[200px] 
            {{ empty($appointment->descriptions) ? 'bg-red-100 border-red-700 text-red-700' : 'bg-green-100 border-green-700 text-green-700' }}">
                                        <i class="fa-solid fa-circle fa-2xs"></i>
                                        {{ empty($appointment->descriptions) ? 'NOT PAID' : 'PAID' }}
                                    </div>
                        </td>
                        <td class="py-3 px-4  gap-5 border-b">
                            <div class='flex justify-center items-center gap-3'>
                                <div class='relative group cursor-pointer'>
                                    <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md'>
                                        <a href="{{ route('cashierinvoince.print', $appointment->id) }}" class="text-blue-600 ">
                                            <i class="fa-solid fa-print" style="color: #0074cb;"></i>
                                        </a>
                                    </div>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded-md py-1 px-2">
                                        Invoice
                                    </div>
                                </div>

                                <div class='cursor-pointer'>
                                    <i class="fa-solid fa-ellipsis-vertical" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu font-medium absolute right-0 z-10 hidden text-left bg-white shadow-lg rounded-lg w-40" aria-labelledby="dropdownMenuButton">
                                        <!-- Edit Option -->
                                        <!-- <a href="{{ route('appointments.edit', $appointment->id) }}" class="block">
                                            <div class="px-4 py-2 flex items-center hover:bg-gray-100">
                                                <i class="fa-regular fa-pen-to-square mr-2 text-gray-600"></i>
                                                <span class="text-sm">Edit</span>
                                            </div>
                                        </a> -->
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
                                                <button type="button" onclick="openDeleteModal('{{ $appointment->first_name }} {{ $appointment->last_name }}', '{{ route('appointmentsinvoice.destroy', $appointment->id) }}')" class="text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </ul>
                                </div>
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
                <h5 class="modal-title mb-3 text-[25px] font-bold" id="deleteAdminModalLabel">Delete Invoice</h5>
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
    <script>
        function openViewModal(appointment) {
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