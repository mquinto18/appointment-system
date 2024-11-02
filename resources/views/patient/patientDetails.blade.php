@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg">
        <div class="py-5 px-10">
            <h1 class="font-medium text-2xl border-b pb-3">Book Appointment</h1>

            @include('patient.navigation')

            <form id="appointmentForm" action="{{ route('appointments.storePatientDetails') }}" method="POST"><!-- Set the form action to your route -->
                @csrf <!-- Include CSRF token for security -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name and Last Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                    </div>

                    <!-- Email and Mobile Number -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                    </div>
                    <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                    </div>

                    <!-- Address -->
                    <div class="col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" id="address" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                    </div>

                    <!-- Birthday and Gender -->
                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">Birthday</label>
                        <input type="date" name="birthday" id="birthday" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <div class="mt-1 flex space-x-4">
                            <div>
                                <input type="radio" name="gender" value="male" id="male" class="mr-2">
                                <label for="male">Male</label>
                            </div>
                            <div>
                                <input type="radio" name="gender" value="female" id="female" class="mr-2">
                                <label for="female">Female</label>
                            </div>
                        </div>
                    </div>

                    <!-- Visit Type and Additional (side by side) -->
                    <div>
                        <label for="visit_type" class="block text-sm font-medium text-gray-700 mb-2">Visit Type</label>
                        <select name="visit_type" id="visit_type" class="mt-1 block w-full rounded-md border border-gray-300 p-2" required>
                            <option value="Medical Consultation">Medical Consultation</option>
                            <option value="Pediatric Consultation">Pediatric Consultation</option>
                            <option value="Pediatric Ears, Nose and Throat">Pediatric Ears, Nose and Throat</option>
                            <option value="Adult Ears, Nose and Throat">Adult Ears, Nose and Throat</option>
                            <option value="Minor Suturing">Minor Suturing</option>
                            <option value="Wound Dressing">Wound Dressing</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="medical_certificate" name="medical_certificate" value="Medical Certificate">
                            <label class="form-check-label" for="medical_certificate">
                                Need Medical Certificate
                            </label>
                        </div>
                    </div>

                </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold hover:bg-blue-600 hover:text-white transition duration-200">Next</button>
        </div>
        </form>

    </div>
</div>

@endsection