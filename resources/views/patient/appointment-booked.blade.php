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
                                    <span class="text-gray-700 font-normal">{{ $appointment->doctor }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel and Reschedule Buttons -->

                    <div class="mt-6 flex">
                        @if(strtolower($appointment->status) === 'cancelled')
                        <!-- Show the Delete button if the appointment is cancelled -->
                        <form method="POST" action="" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full h-12 bg-[#F2F2F2] text-black font-semibold  transition duration-200">
                                Delete
                            </button>
                        </form>
                        @elseif(strtolower($appointment->status) === 'rejected')
                        <!-- Show both Cancel and Reschedule buttons if the appointment is rejected -->
                        <button type="button" class="w-1/2 h-12 bg-[#F2F2F2] border text-black font-semibold flex items-center justify-center hover:text-white hover:bg-gray-600 transition duration-200" onclick="toggleModal(true, {{ $appointment->id }})">
                            Cancel
                        </button>
                        <form method="GET" action="{{ route('appointments.reschedule', $appointment->id) }}" class="w-1/2">
                            @csrf
                            <button type="submit" class="w-full h-12 bg-[#F2F2F2] text-black font-semibold hover:bg-blue-500 hover:text-white transition duration-200">
                                Reschedule
                            </button>
                        </form>
                        @elseif(strtolower($appointment->status) === 'completed')
                        <!-- Show the Rate button if the appointment is completed -->
                        <form method="GET" action="" class="w-full">
                            @csrf
                            <button type="submit" class="w-full h-12 bg-[#F2F2F2] text-black font-semibold hover:bg-yellow-500 hover:text-white transition duration-200">
                                Rate
                            </button>
                        </form>
                        @else
                        <!-- Show the Cancel button if the appointment is not cancelled, rejected, or completed -->
                        <button type="button" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold flex items-center justify-center hover:text-white hover:bg-gray-600 transition duration-200" onclick="toggleModal(true, {{ $appointment->id }})">
                            Cancel
                        </button>
                        @endif

                        <!-- Only show the Download QR button if the status is 'approved' -->
                        @if(strtolower($appointment->status) === 'approved')
                        <button type="button" class="w-full h-12 bg-[#F2F2F2] cursor-pointer border text-black font-semibold hover:bg-blue-600 hover:text-white transition duration-200">Download QR</button>
                        @endif
                    </div>




                </div>
                @endforeach
                @endif
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
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
    // Toggle modal visibility and pass appointment ID
    function toggleModal(show, appointmentId = null) {
        const modal = document.getElementById('cancelModal');
        const cancelForm = document.getElementById('cancelAppointmentForm');

        if (show) {
            modal.classList.remove('hidden');

            // Update form action with the specific appointment ID
            let action = cancelForm.getAttribute('action');
            cancelForm.setAttribute('action', action.replace(':id', appointmentId));
        } else {
            modal.classList.add('hidden');
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