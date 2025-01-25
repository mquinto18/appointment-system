@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div class='max-w-[1600px] mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg">
        <div class="py-5 px-5 md:px-10 ">
            <div class="border-b pb-3 flex justify-between">
                <h1 class="font-medium text-2xl ">Booked Appointments</h1>
                <a href="{{ route('appointment.user') }}" class="bg-[#0074CB] py-2 px-7 text-white font-medium rounded-full">
                    <button>Set Appointment</button>
                </a>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-4 md:gap-10 my-7">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        PE
                    </div>
                    <span>Pending</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        AP
                    </div>
                    <span>Approved</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        CO
                    </div>
                    <span>Completed</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        RE
                    </div>
                    <span>Rejected</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-red-400 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        CA
                    </div>
                    <span>Cancelled</span>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if($appointments->isEmpty())
                <div class="col-span-1 text-center py-10">
                    <p class="text-gray-500">No appointments booked.</p>
                </div>
                @else
                @foreach ($appointments as $appointment)
                <div class="max-w-[1000px] shadow-md">
                    <div class="flex justify-between bg-[#F2F2F2] px-5 py-7">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-user text-[35px]" style="color: #0074cb;"></i>
                            <div class="flex flex-col">
                                <span class="text-[18px] font-bold">{{ $appointment->first_name }} {{ $appointment->last_name }}</span>
                                <span class="text-[13px]">{{ \Carbon\Carbon::parse($appointment->created_at)->format('F j, Y') }}</span>
                            </div>
                        </div>

                        <!-- Status Indicator -->
                        @php
                        $status = strtoupper(substr($appointment->status, 0, 2)); // Get the first letter of the status
                        $bgColor = '';

                        // Determine the background color based on the status
                        if ($status === 'PE') {
                        $bgColor = 'bg-yellow-500'; // Pending
                        } elseif ($status === 'AP') {
                        $bgColor = 'bg-green-600'; // Approved
                        } elseif ($status === 'CO') {
                        $bgColor = 'bg-blue-600'; // Completed
                        } elseif ($status === 'RE') {
                        $bgColor = 'bg-red-600'; // Rejected
                        } elseif ($status === 'CA') {
                        $bgColor = 'bg-red-400'; // Cancelled
                        } else {
                        $bgColor = 'bg-gray-500'; // Default color for unknown status
                        }
                        @endphp

                        <div class="flex justify-center items-center gap-3">
                            <div class="{{ $bgColor }} text-white w-8 h-8 rounded-full flex items-center justify-center">
                                {{ $status }}
                            </div>
                            <div class="relative">
                                <!-- Dropdown Toggle -->
                                <i class="fa-solid fa-ellipsis-vertical cursor-pointer" id="dropdownMenuButton" onclick="toggleDropdown(this)"></i>
                                
                                
                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu absolute right-0 z-10 text-left bg-white shadow-lg rounded-lg w-40 hidden">
                                    <!-- Edit Option -->
                                    <li>
                                        @if ($appointment->status === 'pending')
                                            <a href="{{ route('appointments.userEdit', $appointment->id) }}" class="block px-4 py-2 hover:bg-gray-100">
                                                <i class="fa-regular fa-pen-to-square mr-2 text-gray-600"></i>
                                                Edit
                                            </a>
                                        @else
                                            <span class="block px-4 py-2 text-gray-400 cursor-not-allowed opacity-50">
                                                <i class="fa-regular fa-pen-to-square mr-2 text-gray-400"></i>
                                                Edit
                                            </span>
                                        @endif
                                    </li>
                                    <!-- View Option -->
                                    <li>
                                        <a href="#" 
                                        onclick="openViewModal(
                                            '{{ $appointment->transaction_number }}', 
                                            '{{ $appointment->first_name }} {{ $appointment->last_name }}', 
                                            '{{ $appointment->doctor }}', 
                                            '{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}', 
                                            '{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}', 
                                            '{{ $appointment->visit_type }}', 
                                            '{{ $appointment->additional ?? 'N/A' }}', 
                                            '{{ $appointment->date_of_birth }}', 
                                            '{{ $appointment->gender }}', 
                                            '{{ $appointment->contact_number }}', 
                                            '{{ $appointment->email_address }}', 
                                            '{{ $appointment->complete_address }}'
                                        )" 
                                        class="block px-4 py-2 bg-white hover:bg-gray-200">
                                            <i class="fa-regular fa-eye mr-2 text-gray-600"></i>
                                            View
                                        </a>
                                    </li>

                                    <!-- Delete Option -->
                                    <li>
                                        <form action="#" method="POST" class="block px-4 py-2 hover:bg-gray-100" onsubmit="return false;">
                                            @csrf
                                            @method('DELETE')
                                            <i class="fa-regular fa-trash-can mr-2 text-gray-600"></i>
                                            <button type="button" onclick="openDeleteModal('{{ $appointment->id }}', '{{ $appointment->first_name }} {{ $appointment->last_name }}')" class="text-left">
                                                Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>

                                
                            </div>


                            
                        </div>
                        
                    </div>

                    <!-- Appointment Details -->
                    <div class="flex flex-col px-5 my-4 text-[13px]">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2 relative">
                                    <span class="w-3 h-3 border-2 border-[#9747FF] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 relative">
                                    <span class="w-3 h-3 border-2 border-[#07CC62] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 relative">
                                <div class="flex items-center gap-2 ">
                                    <span class="w-3 h-3 border-2 border-[#0074C8] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">{{ $appointment->visit_type }}</span>
                                </div>
                                <div class="flex items-center gap-2 relative">
                                    <span class="w-3 h-3 border-2 border-[#FD9D2D] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">Dr. {{ $appointment->doctor }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel and Reschedule Buttons -->

                    <div class="mt-6 flex">
                        @if(strtolower($appointment->status) === 'cancelled')
                        <!-- Show the Delete button if the appointment is cancelled -->
                        <!-- <button type="button" onclick="toggleDeleteModal(true, {{ $appointment->id }})" class="w-full h-12 bg-[#F2F2F2] hover:bg-gray-300 text-black font-semibold transition duration-200">
                            Delete
                        </button> -->
                        @elseif(strtolower($appointment->status) === 'rejected')
                        <!-- Show both Cancel and Reschedule buttons if the appointment is rejected -->
                        <button type="button" class="w-1/2 h-12 bg-[#F2F2F2] border  font-semibold flex items-center justify-center hover:bg-gray-300 text-black transition duration-200" onclick="toggleModal(true, {{ $appointment->id }})">
                            Cancel
                        </button>
                        <form method="GET" action="" class="w-1/2">
                            @csrf
                            <button type="button" 
                                class="w-full h-12 bg-[#F2F2F2] font-semibold hover:bg-gray-300 text-black transition duration-200"
                                onclick="toggleRescheduleModal(true, {{ $appointment->id }}, '{{ $appointment->appointment_date }}', '{{ $appointment->appointment_time }}')">
                                Reschedule
                            </button>
                        </form>
                        @elseif(strtolower($appointment->status) === 'completed')
                        <!-- Show the Rate button if the appointment is completed -->
                        <!-- Show both Rate and Delete buttons if the appointment is completed -->
                        <div class="{{ $appointment->additional === 'Medical Certificate' ? 'w-1/2' : 'w-full' }}">
                            <form method="GET" action="" class="w-full">
                                @csrf
                                <button type="button"
                                    id="rateButton"
                                    onclick="toggleRateModal(true, {{ $appointment->id }})"
                                    class="w-full border h-12 bg-[#F2F2F2] text-black font-semibold hover:bg-gray-300 transition duration-200"
                                    @if($appointment->rating) disabled @endif>
                                    Rate
                                </button>
                            </form>
                        </div>

                        @if($appointment->additional === 'Medical Certificate')
                        <div class="w-1/2">
                            <form method="GET" action="{{ route('medicalcert.download', $appointment->id) }}" class="w-full">
                                @csrf
                                <button type="submit" id="downloadButton" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold hover:bg-gray-300 transition duration-200">
                                    Download Medical Certificate
                                </button>
                            </form>
                        </div>
                        @endif



                        @else
                        <!-- Show the Cancel button if the appointment is not cancelled, rejected, or completed -->
                        <button type="button" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold flex items-center justify-center hover:bg-gray-300  transition duration-200" onclick="toggleModal(true, {{ $appointment->id }})">
                            Cancel
                        </button>
                        @endif

                        @if(strtolower($appointment->status) === 'approved')
                        <!-- Form to trigger the modal -->
                        <button type="button" class="w-full h-12 bg-[#F2F2F2] cursor-pointer border text-black font-semibold hover:bg-gray-300 transition duration-200"
                                onclick="showQRCodeModal({{ $appointment->id }}, '{{ $appointment->first_name }} {{ $appointment->last_name }}', '{{ $appointment->visit_type }}', '{{ $appointment->appointment_date }}', '{{ $appointment->complete_address }}')">
                            View QR
                        </button>
                        @endif

                    </div>
                </div>
                @endforeach
                @endif
            </div>

        </div>
    </div>
</div>

<!-- QR Code Modal -->

<div id="qrCodeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-10">
    <div class="modal-dialog bg-[#0074C8] rounded-lg w-[90%] sm:w-[450px] shadow-lg relative">
        <!-- Close button (using &times;) -->
        <button onclick="toggleQRCodeModal(false)" class="absolute top-2 right-4 text-[30px] text-white">
            &times;
        </button>

        <div class="modal-content text-center">
            <div class="modal-body mb-5 px-10 py-5">
                <h5 class="text-[17px] text-white font-semibold mb-3 py-3">Please show this QR code upon arrival.</h5>

                <div class="bg-white font-semibold py-5 rounded-2xl">
                    <div class="pb-2">
                        <span id="appointmentName" class="text-[20px]"></span><br>
                    </div>
                    <div class="font-normal text-[15px]">
                        <span id="visitType"></span><br>
                        <span>Schedule Date: <span id="appointmentDate" class="font-medium"></span></span><br>
                        <span>Address: <span id="appointmentTime" class="font-medium"></span></span><br>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="h-16 w-16 ml-[-30px] bg-[#0074C8] rounded-full"></div>
                        <div class="flex-grow border-t-4 border-dashed border-[#D9D9D9]"></div>
                        <div class="h-16 w-16 mr-[-30px] bg-[#0074C8] rounded-full"></div>
                    </div>

                    <div id="qrCodeImage" class="my-4">
                        <!-- QR code will be inserted here -->
                    </div>
                </div>
            </div>

            <form id="qrCodeForm" action="{{ route('appointments.downloadQRPdf', ':id') }}" method="GET">
                @csrf
                <input type="hidden" id="qrCodeData" name="qrCodeData" value="">

                <div class="flex justify-center border-t border-gray-200">
                    <button type="submit" class="w-full py-4 bg-[#F2F2F2] font-semibold hover:bg-gray-300 rounded-br-md">
                        Download QR as PDF
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Reschedule Modal -->

<div id="rescheduleModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-10">
    <div class="modal-dialog bg-white rounded-lg w-[90%] sm:w-[650px] shadow-lg transition-transform duration-300">
        <div class="modal-content text-center">
            <div class="modal-body">
                <h5 class="text-[24px] font-bold mb-3 mt-8">Your appointment has been Rescheduled to</h5>
                
                <form id="rescheduleAppointmentForm" method="POST" action="{{ route('appointments.reschedule', ':id') }}">
                    @csrf
              
                    <!-- Date and Time Input Fields -->
                    <div class="flex justify-between mb-6 px-12 py-8">
                        <div class="w-[48%]">
                            <label for="appointment_date" class="block text-left text-sm font-semibold text-gray-500 mb-1">Date</label>
                            <input type="date" id="appointment_date" name="appointment_date" 
                                value="" 
                                class="block w-full text-gray-600 font-medium bg-gray-100 rounded-md p-3 border border-gray-300 focus:outline-none" readonly>
                        </div>
                        <div class="w-[48%]">
                            <label for="appointment_time" class="block text-left text-sm font-semibold text-gray-500 mb-1">Time</label>
                            <input type="time" id="appointment_time" name="appointment_time" 
                                value="" 
                                class="block w-full text-gray-600 font-medium bg-gray-100 rounded-md p-3 border border-gray-300 focus:outline-none" readonly>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex border-t border-gray-200">
                        <button type="button" 
                            class="w-1/2 py-4 bg-[#F2F2F2] font-semibold border-r hover:bg-gray-300 rounded-bl-md border-gray-200" 
                            onclick="toggleRescheduleModal(false)">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="w-1/2  py-4 bg-[#F2F2F2] font-semibold hover:bg-gray-300 rounded-br-md">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-10">
    <div class="modal-dialog bg-white rounded-lg w-[90%] sm:w-[450px] shadow-lg">
        <div class="modal-content text-center">
            <div class="modal-body mb-5 px-10 py-5">
                <i class="fa-solid fa-triangle-exclamation text-[55px] my-4" style="color: #ff0000;"></i>
                <h5 class="text-[25px] font-bold mb-3">Delete Appointment</h5>
                <p class="text-gray-600">Are you you sure want to delete?
                    Once deleted it cannot be recovered.</p>
            </div>
            <div class="flex justify-between border-t border-gray-200">
                <button type="button" class="w-1/2 py-4 bg-[#F2F2F2] font-semibold border-r hover:bg-gray-300 rounded-bl-md" onclick="toggleDeleteModal(false)">Cancel</button>
                <form id="deleteAppointmentForm" method="POST" action="{{ route('appointments.delete', ':id') }}" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-[#F2F2F2] font-semibold hover:bg-gray-300 rounded-br-md">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-10">
    <div class="modal-dialog bg-white rounded-lg w-[90%] sm:w-[450px] shadow-lg transition-transform duration-300">
        <div class="modal-content text-center">
            <div class="modal-body mb-5 px-10 py-5">
                <i class="fa-solid fa-triangle-exclamation text-[55px] my-4 text-red-600"></i>
                <h5 class="text-[25px] font-bold mb-3">Cancel Appointment</h5>
                <p class="text-gray-600">Are you sure you don't want to continue with your appointment?</p>
            </div>
            <div class="flex justify-between border-t border-gray-200">
                <button type="button" class="w-1/2 py-4 bg-[#F2F2F2] font-semibold border-r hover:bg-gray-300 rounded-bl-md border-gray-200" onclick="toggleModal(false)">Cancel</button>
                <form id="cancelAppointmentForm" method="POST" action="{{ route('appointments.cancel', ':id') }}" class="w-1/2">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-[#F2F2F2] font-semibold hover:bg-gray-300 rounded-br-md">Yes, Cancel My Appointment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Rate Modal -->

<style>
    .star-button {
        color: #ccc;
        /* Default color */
    }

    .star-button.selected {
        color: #0074C8;
        /* Gold color for selected stars */
    }
</style>

<div id="rateModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-10">
    <div class="modal-dialog bg-white rounded-lg w-[95%] sm:w-[500px] shadow-lg relative">
        <div class="modal-content text-center">
            <!-- Close Button -->
            <button onclick="toggleRateModal(false)" class="absolute top-2 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
            <div class="modal-body mb-5 px-10 py-5">
                <h5 class="text-[25px] font-bold mb-5">Appointment Completed!</h5>
                <p class="text-gray-600 mb-4">How satisfied are you with our service?</p>
                <div class="flex gap-2 justify-between">
                    <button type="button" id="star-5" class="star-button focus:outline-none flex flex-col items-center" onclick="selectRating(5)">
                        <i class="fa fa-star fa-3x"></i> <!-- Increased the size here -->
                        <p class="text-sm mt-2">Very Satisfied</p>
                    </button>
                    <button type="button" id="star-4" class="star-button focus:outline-none flex flex-col items-center" onclick="selectRating(4)">
                        <i class="fa fa-star fa-3x"></i> <!-- Increased the size here -->
                        <p class="text-sm mt-2">Satisfied</p>
                    </button>
                    <button type="button" id="star-3" class="star-button focus:outline-none flex flex-col items-center" onclick="selectRating(3)">
                        <i class="fa fa-star fa-3x"></i> <!-- Increased the size here -->
                        <p class="text-sm mt-2">Neutral</p>
                    </button>
                    <button type="button" id="star-2" class="star-button focus:outline-none flex flex-col items-center" onclick="selectRating(2)">
                        <i class="fa fa-star fa-3x"></i> <!-- Increased the size here -->
                        <p class="text-sm mt-2">Unsatisfied</p>
                    </button>
                    <button type="button" id="star-1" class="star-button focus:outline-none flex flex-col items-center" onclick="selectRating(1)">
                        <i class="fa fa-star fa-3x"></i> <!-- Increased the size here -->
                        <p class="text-sm mt-2">Very Unsatisfied</p>
                    </button>
                </div>
            </div>

            <div class="flex justify-between border-t border-gray-200">
                <!-- Changed Submit to Action -->
                <form id="rateAppointmentForm" method="POST" action="{{ route('appointments.rate', ':id') }}" class="w-full" onsubmit="disableRateButton()">
                    @csrf
                    <input type="hidden" name="rating" id="ratingInput" value="">
                    <button type="submit" class="w-full py-4 bg-[#F2F2F2] font-semibold hover:bg-gray-300 rounded-b-md" onclick="updateRatingInput()" id="submitRateButton">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- The Modal -->
<div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4">
        <div class="flex justify-between items-center border-b px-4 py-2">
            <h2 class="text-lg font-semibold">Appointment Details</h2>
            <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-800 text-[30px]">&times;</button>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Transaction Number:</label>
                <input id="transactionNumber" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Patient Name:</label>
                <input id="patientName" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Doctor:</label>
                <input id="doctorName" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Appointment Date:</label>
                <input id="appointmentDate" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Appointment Time:</label>
                <input id="appointmentTime" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Visit Type:</label>
                <input id="visitType" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div class="col-span-2 md:col-span-3">
                <label class="block text-gray-700 font-medium">Additional Information:</label>
                <textarea id="additionalInfo" class="w-full px-3 py-2 border rounded-md" readonly></textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Date of Birth:</label>
                <input id="dob" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Gender:</label>
                <input id="gender" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Contact Number:</label>
                <input id="contactNumber" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Email Address:</label>
                <input id="email" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Complete Address:</label>
                <input id="complete_address" type="text" class="w-full px-3 py-2 border rounded-md" readonly>
            </div>
        </div>
    </div>
</div>






<script>

function toggleRescheduleModal(show, appointmentId = null, appointmentDate = null, appointmentTime = null) {
    const rescheduleModal = document.getElementById('rescheduleModal');
    const formAction = `{{ route('appointments.reschedule', ':id') }}`.replace(':id', appointmentId);
    const rescheduleForm = document.getElementById('rescheduleAppointmentForm');

    // Set the form action
    if (appointmentId) {
        rescheduleForm.action = formAction;
    }

    // Set the date and time in the modal
    document.getElementById('appointment_date').value = appointmentDate || '';
    document.getElementById('appointment_time').value = appointmentTime || '';

    // Show or hide the modal
    if (show) {
        rescheduleModal.classList.remove('opacity-0', 'pointer-events-none');
        rescheduleModal.classList.add('opacity-100');
    } else {
        rescheduleModal.classList.add('opacity-0', 'pointer-events-none');
        rescheduleModal.classList.remove('opacity-100');
    }
}


function disableRateButton() {
        document.getElementById('submitRateButton').disabled = true;
        document.getElementById('submitRateButton').textContent = 'Submitting...';
    }
    // Toggle cancel modal
    function toggleModal(show, appointmentId = null) {
        const modal = document.getElementById('cancelModal');
        const cancelForm = document.getElementById('cancelAppointmentForm');
        const modalDialog = modal.querySelector('.modal-dialog');

        if (show) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            modalDialog.classList.remove('scale-95');
            modalDialog.classList.add('scale-100');

            if (appointmentId) {
                let action = cancelForm.getAttribute('action');
                cancelForm.setAttribute('action', action.replace(':id', appointmentId));
            }
        } else {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalDialog.classList.remove('scale-100');
            modalDialog.classList.add('scale-95');
        }
    }

    // Toggle QR code modal
    function toggleQRCodeModal(show) {
        const qrCodeModal = document.getElementById('qrCodeModal');

        if (show) {
            qrCodeModal.classList.remove('opacity-0', 'pointer-events-none');
            qrCodeModal.classList.add('opacity-100', 'pointer-events-auto');
            qrCodeModal.querySelector('.modal-dialog').classList.remove('scale-95');
            qrCodeModal.querySelector('.modal-dialog').classList.add('scale-100');
        } else {
            qrCodeModal.classList.remove('opacity-100', 'pointer-events-auto');
            qrCodeModal.classList.add('opacity-0', 'pointer-events-none');
            qrCodeModal.querySelector('.modal-dialog').classList.remove('scale-100');
            qrCodeModal.querySelector('.modal-dialog').classList.add('scale-95');
        }
    }

    // Show the modal and load the QR code dynamically via AJAX
    function showQRCodeModal(appointmentId, name, visitType, appointmentDate, appointmentAddress) {
    // Show the modal
    toggleQRCodeModal(true);

    // Set dynamic content in modal
    document.getElementById('appointmentName').textContent = name;
    document.getElementById('visitType').textContent = visitType;
    document.getElementById('appointmentDate').textContent = appointmentDate;
    document.getElementById('appointmentTime').textContent = appointmentAddress;

    // Dynamically update form action with appointmentId
    var form = document.getElementById('qrCodeForm');
    form.action = "{{ route('appointments.downloadQRPdf', ':id') }}".replace(':id', appointmentId);

    // Fetch and display the QR code
    fetch(`/dashboard/appointment/appointment-qrcode/${appointmentId}`)
        .then(response => response.blob())
        .then(imageBlob => {
            const imageUrl = URL.createObjectURL(imageBlob);
            document.getElementById('qrCodeImage').innerHTML = `<img src="${imageUrl}" alt="QR Code" class="mx-auto w-[200px]" />`;

            // Set QR code data to hidden input for PDF download
            document.getElementById('qrCodeData').value = imageUrl; // Or base64 string if needed
        })
        .catch(error => {
            console.error("Error fetching QR code:", error);
        });
}







    // Toggle delete modal
    function toggleDeleteModal(show, appointmentId = null) {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteAppointmentForm');

        if (show) {
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteModal.classList.add('opacity-100', 'pointer-events-auto');
            deleteModal.querySelector('div').classList.remove('scale-95');
            deleteModal.querySelector('div').classList.add('scale-100');

            if (appointmentId) {
                let action = deleteForm.getAttribute('action');
                deleteForm.setAttribute('action', action.replace(':id', appointmentId));
            }
        } else {
            deleteModal.classList.remove('opacity-100', 'pointer-events-auto');
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteModal.querySelector('div').classList.remove('scale-100');
            deleteModal.querySelector('div').classList.add('scale-95');
        }
    }

    let selectedRating = null;
    let appointmentId = null;

    function selectRating(rating) {
        selectedRating = rating;

        // Remove selected class from all stars
        document.querySelectorAll('.star-button').forEach(button => {
            button.classList.remove('selected');
        });

        // Add selected class to the chosen star
        document.getElementById(`star-${rating}`).classList.add('selected');

        console.log("Selected rating:", selectedRating); // For debugging
    }

    // Update the hidden input field with the selected rating value
    function updateRatingInput() {
        if (selectedRating) {
            document.getElementById('ratingInput').value = selectedRating;
        }
    }

    // Function to toggle the rate modal and set the appointment ID
    function toggleRateModal(show, id = null) {
        const rateModal = document.getElementById('rateModal');

        if (show) {
            appointmentId = id; // Set the appointment ID when opening the modal
            rateModal.classList.remove('opacity-0', 'pointer-events-none');
            rateModal.classList.add('opacity-100', 'pointer-events-auto');

            // Update the action URL with the appointment ID
            const formAction = document.getElementById('rateAppointmentForm').action.replace(':id', appointmentId);
            document.getElementById('rateAppointmentForm').action = formAction;
        } else {
            rateModal.classList.remove('opacity-100', 'pointer-events-auto');
            rateModal.classList.add('opacity-0', 'pointer-events-none');
            selectedRating = null; // Reset the selected rating when closing the modal
            appointmentId = null; // Reset the appointment ID

            // Remove the selected class from all stars when closing the modal
            document.querySelectorAll('.star-button').forEach(button => {
                button.classList.remove('selected');
            });
        }
    }




    // Cancel appointment functionality
    document.getElementById('confirmCancelBtn').addEventListener('click', function() {
        const appointmentId = this.getAttribute('data-appointment-id');
        if (appointmentId) {
            // Make an AJAX request or submit form to cancel the appointment
            alert('Appointment ' + appointmentId + ' has been canceled.');
            toggleModal(false); // Hide the modal after confirmation
        }
    });



    function toggleDropdown(button) {
    // Get the dropdown menu element (next sibling)
    const dropdownMenu = button.nextElementSibling;

    // Toggle visibility of the dropdown menu
    if (dropdownMenu.classList.contains('hidden')) {
        dropdownMenu.classList.remove('hidden');
    } else {
        dropdownMenu.classList.add('hidden');
    }
}

// Close dropdown if clicked outside
document.addEventListener('click', function (event) {
    const dropdownButtons = document.querySelectorAll('#dropdownMenuButton');
    dropdownButtons.forEach((button) => {
        const dropdownMenu = button.nextElementSibling;
        if (dropdownMenu && !button.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
});


function openDeleteModal(appointmentId, fullName) {
    // Update the modal text with the appointment details
    const modalText = `Are you sure you want to delete ${fullName}'s appointment? Once deleted, it cannot be recovered.`;
    document.querySelector('#deleteModal .modal-body p').textContent = modalText;

    // Set the form action URL dynamically
    const formAction = document.querySelector('#deleteAppointmentForm');
    formAction.action = formAction.action.replace(':id', appointmentId);

    // Show the modal
    toggleDeleteModal(true);
}

function toggleDeleteModal(show) {
    const modal = document.getElementById('deleteModal');
    if (show) {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
    } else {
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
    }
}


function openViewModal(transactionNumber, patientName, doctorName, appointmentDate, appointmentTime, visitType, additionalInfo, dob, gender, contactNumber, email, complete_address) {
    // Populate the modal fields with the appointment details
    document.getElementById('transactionNumber').value = transactionNumber;
    document.getElementById('patientName').value = patientName;
    document.getElementById('doctorName').value = doctorName;
    document.getElementById('appointmentDate').value = appointmentDate;
    document.getElementById('appointmentTime').value = appointmentTime;
    document.getElementById('visitType').value = visitType;
    document.getElementById('additionalInfo').value = additionalInfo;
    document.getElementById('dob').value = dob;
    document.getElementById('gender').value = gender;
    document.getElementById('contactNumber').value = contactNumber;
    document.getElementById('email').value = email;
    document.getElementById('complete_address').value = complete_address;

    // Show the modal
    const modal = document.getElementById('viewModal');
    modal.classList.remove('hidden');
}

function closeViewModal() {
    const modal = document.getElementById('viewModal');
    modal.classList.add('hidden');
}

window.onclick = function(event) {
    const modal = document.getElementById('viewModal');
    if (event.target === modal) {
        modal.classList.add('hidden');
    }
}
</script>
@endsection