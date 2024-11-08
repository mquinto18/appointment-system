@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div class='max-w-[1600px] mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg">
        <div class="py-5 px-5 md:px-10">
            <h1 class="font-medium text-2xl border-b pb-3">Booked Appointments</h1>

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

                        <div class="{{ $bgColor }} text-white w-8 h-8 rounded-full flex items-center justify-center">
                            {{ $status }}
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
                        <button type="button" onclick="toggleDeleteModal(true, {{ $appointment->id }})" class="w-full h-12 bg-[#F2F2F2] hover:bg-gray-300 text-black font-semibold transition duration-200">
                            Delete
                        </button>
                        @elseif(strtolower($appointment->status) === 'rejected')
                        <!-- Show both Cancel and Reschedule buttons if the appointment is rejected -->
                        <button type="button" class="w-1/2 h-12 bg-[#F2F2F2] border  font-semibold flex items-center justify-center hover:bg-gray-300 text-black transition duration-200" onclick="toggleModal(true, {{ $appointment->id }})">
                            Cancel
                        </button>
                        <form method="GET" action="" class="w-1/2">
                            @csrf
                            <button type="submit" class="w-full h-12 bg-[#F2F2F2] font-semibold hover:bg-gray-300 text-black  transition duration-200">
                                Reschedule
                            </button>
                        </form>
                        @elseif(strtolower($appointment->status) === 'completed')
                        <!-- Show the Rate button if the appointment is completed -->
                        <form method="GET" action="" class="w-full">
                            @csrf
                            <button type="submit" class="w-full h-12 bg-[#F2F2F2] text-black font-semibold hover:bg-gray-300  transition duration-200">
                                Rate
                            </button>
                        </form>
                        @else
                        <!-- Show the Cancel button if the appointment is not cancelled, rejected, or completed -->
                        <button type="button" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold flex items-center justify-center hover:bg-gray-300  transition duration-200" onclick="toggleModal(true, {{ $appointment->id }})">
                            Cancel
                        </button>
                        @endif

                        @if(strtolower($appointment->status) === 'approved')
                        <!-- Form to trigger the modal -->
                        <button type="button" class="w-full h-12 bg-[#F2F2F2] cursor-pointer border text-black font-semibold hover:bg-gray-300 transition duration-200" onclick="showQRCodeModal({{ $appointment->id }})">
                            Download QR
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
<div id="qrCodeModal" class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-10">
    <div class="modal-dialog bg-[#0074C8] rounded-lg w-[90%] sm:w-[450px] shadow-lg">
        <div class="modal-content text-center">
            <div class="modal-body mb-5 px-10 py-5">
                <h5 class="text-[17px] text-white font-semibold mb-3 py-3">Please show this QR code upon arrival.</h5>


                <div class="bg-white font-semibold py-5 rounded-2xl">
                    <div class="pb-2">
                        <span class="text-[20px]">Clinic Details</span><br>
                    </div>
                    <div class="font-normal text-[15px]">
                        <span>St. Benedict Medical Clinic & Pharmacy</span></span><br>
                        <span>Contact: <span class="font-medium">+1 (555) 123-4567</span></span><br>
                        <span>Address: <span class="font-medium">123 Wellness Avenue, Suite 101</span></span><br>
                    </div>


                    <div class="flex justify-between items-center">
                        <div class="h-16 w-16 ml-[-30px] bg-[#0074C8] rounded-full"></div>
                        <div class="flex-grow border-t-4 border-dashed border-[#D9D9D9]"></div> <!-- This will ensure the dashed line spans available space -->
                        <div class="h-16 w-16 mr-[-30px] bg-[#0074C8] rounded-full"></div>
                    </div>

                    <div id="qrCodeImage" class="my-4">

                        <!-- QR code will be inserted here -->
                    </div>
                </div>
            </div>
            <div class="flex justify-center border-t border-gray-200">
                <button type="button" class="w-full py-4 bg-[#F2F2F2] font-semibold hover:bg-gray-300 rounded-br-md" onclick="toggleQRCodeModal(false)">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-10">
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
<div id="cancelModal" class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-10">
    <div class="modal-dialog bg-white rounded-lg w-[90%] sm:w-[450px] shadow-lg">
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



<script>
    // Toggle cancel modal
    function toggleModal(show, appointmentId = null) {
        const modal = document.getElementById('cancelModal');
        const cancelForm = document.getElementById('cancelAppointmentForm');

        if (show) {
            modal.classList.remove('hidden');
            let action = cancelForm.getAttribute('action');
            cancelForm.setAttribute('action', action.replace(':id', appointmentId));
        } else {
            modal.classList.add('hidden');
        }
    }

    function toggleQRCodeModal(show) {
        const modal = document.getElementById('qrCodeModal');
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    // Show the modal and load the QR code dynamically via AJAX
    function showQRCodeModal(appointmentId) {
        // Show the modal
        toggleQRCodeModal(true);

        // Send an AJAX request to get the QR code image for this appointment
        fetch(`/dashboard/appointment/appointment-qrcode/${appointmentId}`)
            .then(response => response.blob()) // Expecting the QR image as a blob
            .then(imageBlob => {
                // Create an object URL for the image blob
                const imageUrl = URL.createObjectURL(imageBlob);
                // Insert the QR code image into the modal
                const qrCodeContainer = document.getElementById('qrCodeImage');
                qrCodeContainer.innerHTML = `<img src="${imageUrl}" alt="QR Code" class="mx-auto w-[200px]" />`;
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
            deleteModal.classList.remove('hidden');
            let action = deleteForm.getAttribute('action');
            deleteForm.setAttribute('action', action.replace(':id', appointmentId));
        } else {
            deleteModal.classList.add('hidden');
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
</script>
@endsection