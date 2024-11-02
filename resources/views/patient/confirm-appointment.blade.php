@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg ">
        <div class="py-5 px-10">
            <h1 class="font-medium text-2xl border-b pb-3">Book Appointment</h1>

            @include('patient.navigation')

            <form id="appointmentForm" action="{{ route('appointments.confirm') }}" method="POST">
                @csrf <!-- Include CSRF token for security -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name and Last Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                            value="{{ $patientDetails['first_name'] ?? '' }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" disabled>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                            value="{{ $patientDetails['last_name'] ?? '' }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" disabled>
                    </div>
                    <div>
                        <label for="visit_type" class="block text-sm font-medium text-gray-700 mb-2">Visit Type</label>
                        <input type="text" name="visit_type" id="visit_type"
                            value="{{ $patientDetails['visit_type'] ?? '' }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" disabled>
                    </div>
                    <div>
                        <label for="additional" class="block text-sm font-medium text-gray-700 mb-2">Additional (Medical Certificate)</label>
                        <input type="text" name="additional" id="additional"
                            value="{{ $patientDetails['medical_certificate'] ?? '' }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" disabled>
                    </div>
                </div>

                <h1 class="font-medium text-xl pb-3 mt-6">Scheduled Date & Time</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date and Time Inputs -->
                    <div>
                        <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="scheduled_date" id="scheduled_date"
                            value="{{ $date ?? '' }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" disabled>
                    </div>
                    <div>
                        <label for="scheduled_time" class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                        <input type="time" name="scheduled_time" id="scheduled_time"
                            value="{{ $time ? \Carbon\Carbon::createFromFormat('g:i A', $time)->format('H:i') : '' }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" disabled>
                    </div>
                </div>
        </div>

        <div class="mt-6 flex">
            <a href="{{ route('home') }}" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold flex items-center justify-center hover:text-white hover:bg-gray-600 transition duration-200">Cancel</a>

            <button type="submit" class="w-full h-12 bg-[#F2F2F2] cursor-pointer border text-black font-semibold hover:bg-blue-600 hover:text-white transition duration-200">Submit</button>
        </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
@if(session('message'))
<div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full relative flex flex-col items-center">
        <i class="fa-solid fa-check-to-slot my-5 text-6xl" style="color: #07cc62;"></i> <!-- Increased size -->
        <h2 class="text-[25px] mb-4 text-center font-bold">Confirmed!</h2>
        <p class="text-center">{{ session('message') }}</p>
        
        <!-- Close button with 'X' icon -->
        <button id="closeModal" class="absolute top-3 right-3 text-xl text-gray-600 hover:text-gray-800">
            <i class="fa-solid fa-xmark"></i> <!-- 'X' icon -->
        </button>
    </div>
</div>

@endif

<script>
    // Function to close the modal
    document.getElementById('closeModal').addEventListener('click', function () {
        const modal = document.getElementById('confirmationModal');
        modal.classList.add('hidden'); // Hide the modal on close
    });
</script>

@endsection
