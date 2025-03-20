@extends('layouts.doctor')

@section('title', 'Doctor')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Appointment</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>Follow-up Check up</span>
    </div>

    <div class='bg-white w-full rounded-lg shadow-md p-8'>
        <div class='mb-4'>
            <span class='font-medium text-[#0074C8]'>Patient Details</span>
        </div>

        <form action="{{ route('appointments.doctorfollowUpPost', $appointment->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

                <div class="mb-4">
                    <label for="firstName" class="form-label font-medium text-gray-700 block mb-2">First Name</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="firstName" name="first_name" value="{{ old('first_name', $appointment->first_name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="lastName" class="form-label font-medium text-gray-700 block mb-2">Last Name</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lastName" name="last_name" value="{{ old('last_name', $appointment->last_name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="dateOfBirth" class="form-label font-medium text-gray-700 block mb-2">Date of Birth</label>
                    <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="dateOfBirth" name="date_of_birth" value="{{ old('date_of_birth', $appointment->date_of_birth) }}" required>
                </div>

                <div class="mb-4">
                    <label for="appointmentDate" class="form-label font-medium text-gray-700 block mb-2">Appointment Date</label>
                    <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentDate" name="appointment_date" value="" required>
                </div>

                <div class="mb-4">
                    <label for="appointmentTime" class="form-label font-medium text-gray-700 block mb-2">Appointment Time</label>
                    <select class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentTime" name="appointment_time" required>
                        <option value="">Select a time</option>
                        <option value="09:00 AM">9:00 AM</option>
                        <option value="09:30 AM">9:30 AM</option>
                        <option value="10:00 AM">10:00 AM</option>
                        <option value="10:30 AM">10:30 AM</option>
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="11:30 AM">11:30 AM</option>
                        <option value="01:00 PM">1:00 PM</option>
                        <option value="01:30 PM">1:30 PM</option>
                        <option value="02:00 PM">2:00 PM</option>
                        <option value="02:30 PM">2:30 PM</option>
                        <option value="03:00 PM">3:00 PM</option>
                        <option value="03:30 PM">3:30 PM</option>
                    </select>
                </div>


                <div class="mb-4">
                    <label for="visitType" class="form-label font-medium text-gray-700 block mb-2">Visit Type</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="visitType" name="visit_type" value="{{ old('visit_type', $appointment->visit_type) }}" required>
                </div>

                <div class="mb-4">
                    <label for="additional" class="form-label font-medium text-gray-700 block mb-2">Additional Information</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="medicalCertificate" name="additional" value="Medical Certificate" {{ old('additional', $appointment->additional) == 'Medical Certificate' ? 'checked' : '' }}>
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
                    <select class="form-select block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="gender" name="gender" required>
                        <option value="Male" {{ old('gender', $appointment->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $appointment->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $appointment->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="maritalStatus" class="form-label font-medium text-gray-700 block mb-2">Marital Status</label>
                    <select class="form-select block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="maritalStatus" name="marital_status" required>
                        <option value="Single" {{ old('marital_status', $appointment->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('marital_status', $appointment->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ old('marital_status', $appointment->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="contactNumber" class="form-label font-medium text-gray-700 block mb-2">Contact Number</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="contactNumber" name="contact_number" value="{{ old('contact_number', $appointment->contact_number) }}" required>
                </div>

                <div class="mb-4">
                    <label for="emailAddress" class="form-label font-medium text-gray-700 block mb-2">Email Address</label>
                    <input type="email" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="emailAddress" name="email_address" value="{{ old('email_address', $appointment->email_address) }}" required>
                </div>

                <div class="mb-4">
                    <label for="completeAddress" class="form-label font-medium text-gray-700 block mb-2">Complete Address</label>
                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="completeAddress" name="complete_address" value="{{ old('complete_address', $appointment->complete_address) }}" required>
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