@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg p-10">
        <h1 class="font-medium text-2xl border-b pb-3">Book Appointment</h1>

        @include('patient.navigation')

        <form id="appointmentForm" action="" method="POST">
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

            <div class="mt-6 flex gap-4">
                <a href="{{ route('home') }}" class="w-full h-12 bg-gray-500 text-white font-semibold rounded-md flex items-center justify-center hover:bg-gray-600 transition duration-200">Cancel</a>

                <button type="submit" class="w-full h-12 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200" disabled>Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
