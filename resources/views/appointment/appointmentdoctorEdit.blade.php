@extends('layouts.doctor')

@section('title', 'Doctor')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Appointment</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>Update Appointment</span>
    </div>

    <div class='bg-white w-full rounded-lg shadow-md p-8'>
        <div class='mb-4'>
            <span class='font-medium text-[#0074C8]'>Patient Details</span>
        </div>

        <form action="{{ route('appointments.doctorUpdate', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Indicate that this is a PUT request for updating -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

                <div class="mb-4">
                    <label for="firstName" class="form-label font-medium text-gray-700 block mb-2">First Name</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="firstName" name="first_name" value="{{ old('first_name', $appointment->first_name) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="lastName" class="form-label font-medium text-gray-700 block mb-2">Last Name</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lastName" name="last_name" value="{{ old('last_name', $appointment->last_name) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="dateOfBirth" class="form-label font-medium text-gray-700 block mb-2">Date of Birth</label>
                    <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="dateOfBirth" name="date_of_birth" value="{{ old('date_of_birth', $appointment->date_of_birth) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="appointmentDate" class="form-label font-medium text-gray-700 block mb-2">Appointment Date</label>
                    <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentDate" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="appointmentTime" class="form-label font-medium text-gray-700 block mb-2">Appointment Time</label>
                    <input type="time" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentTime" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="visitType" class="form-label font-medium text-gray-700 block mb-2">Visit Type</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="firstName" name="visit_type" value="{{ old('visit_type', $appointment->visit_type) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="additional" class="form-label font-medium text-gray-700 block mb-2">Additional Information</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="medicalCertificate" name="additional" value="Medical Certificate" readonly  {{ old('additional', $appointment->additional) == 'Medical Certificate' ? 'checked' : '' }} >
                        <label class="form-check-label" for="medicalCertificate">Medical Certificate</label>
                    </div>
                </div>


                <div class="mb-4">
                    <label for="doctor" class="form-label font-medium text-gray-700 block mb-2">Doctor</label>
                    <input type="text"
                        class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="doctor"
                        name="doctor"
                        value="{{ old('doctor', $appointment->doctor) }}"
                        readonly>
                </div>


                <div class="mb-4">
                    <label for="gender" class="form-label font-medium text-gray-700 block mb-2">Gender</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="contactNumber" name="contact_number" value="{{ old('contact_number', $appointment->gender) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="contactNumber" class="form-label font-medium text-gray-700 block mb-2">Contact Number</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="contactNumber" name="contact_number" value="{{ old('contact_number', $appointment->contact_number) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="emailAddress" class="form-label font-medium text-gray-700 block mb-2">Email Address</label>
                    <input type="email" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="emailAddress" name="email_address" value="{{ old('email_address', $appointment->email_address) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="completeAddress" class="form-label font-medium text-gray-700 block mb-2">Complete Address</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="completeAddress" name="complete_address" value="{{ old('complete_address', $appointment->complete_address) }}" readonly>
                </div>

                <div class="col-span-1 md:col-span-3 mb-4">
                    <label for="notes" class="form-label font-medium text-gray-700 block mb-2">Notes</label>
                    <textarea class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="notes" name="notes">{{ old('notes', $appointment->notes) }}</textarea>
                </div>
                <div class="col-span-1 md:col-span-3 mb-4">
                    <label for="diagnosis" class="form-label font-medium text-gray-700 block mb-2">Diagnosis</label>
                    <textarea class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="diagnosis" name="diagnosis">{{ old('diagnosis', $appointment->diagnosis) }}</textarea>
                </div>


            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600">Update Appointment</button>
            </div>
        </form>
    </div>
</div>

@endsection