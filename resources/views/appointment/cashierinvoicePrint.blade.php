    @extends('layouts.cashier')

    @section('title', 'cashier')

    @section('contents')

    <div>
        <h1 class='font-medium text-2xl ml-3'>Medical Billing Invoice</h1>
    </div>
    <div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>
    <div class='mx-10 -mt-16'>
        <div class='flex justify-between mb-2'>
            <span class='text-[20px] text-white font-medium'>View Medical Invoice</span>
        </div>

        <div class='bg-white w-full rounded-lg shadow-md p-8'>
            <div class='flex gap-5 flex-wrap'>
                <!-- Left section (Patient details form) -->
                <div class="flex-1"> <!-- Add flex-grow to maximize the width -->
                    <div class='mb-4'>
                        <span class='font-medium text-[#0074C8]'>Patient Details</span>
                    </div>

                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3"> <!-- Two-column layout with gap -->

                            <!-- Transaction Number -->
                            <div class="mb-1">
                                <label for="transaction" class="form-label font-medium text-gray-700 block mb-2">Transaction Number:</label>
                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="transaction" name="transaction" value="{{ old('transaction_number', $appointment->transaction_number) }}" disabled>
                            </div>

                            <!-- First Name -->
                            <div class="mb-1">
                                <label for="firstName" class="form-label font-medium text-gray-700 block mb-2">First Name</label>
                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="firstName" name="first_name" value="{{ old('first_name', $appointment->first_name) }}" disabled>
                            </div>

                            <!-- Last Name -->
                            <div class="mb-1">
                                <label for="lastName" class="form-label font-medium text-gray-700 block mb-2">Last Name</label>
                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lastName" name="last_name" value="{{ old('last_name', $appointment->last_name) }}" disabled>
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-1">
                                <label for="dateOfBirth" class="form-label font-medium text-gray-700 block mb-2">Date of Birth</label>
                                <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="dateOfBirth" name="date_of_birth" value="{{ old('date_of_birth', $appointment->date_of_birth) }}" disabled>
                            </div>

                            <!-- Appointment Date -->
                            <div class="mb-1">
                                <label for="appointmentDate" class="form-label font-medium text-gray-700 block mb-2">Appointment Date</label>
                                <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentDate" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" disabled>
                            </div>

                            <!-- Appointment Time -->
                            <div class="mb-1">
                                <label for="appointmentTime" class="form-label font-medium text-gray-700 block mb-2">Appointment Time</label>
                                <input type="time" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentTime" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" disabled>
                            </div>

                            <!-- Visit Type -->
                            <div class="mb-1">
                                <label for="visitType" class="form-label font-medium text-gray-700 block mb-2">Visit Type</label>
                                <input type="" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="visit_type" name="visit_type" value="{{ old('visit_type', $appointment->visit_type) }}" disabled>
                            </div>

                            <!-- Additional Information -->
                            <div class="mb-1">
                                <label for="additional" class="form-label font-medium text-gray-700 block mb-2">Additional Information</label>
                                <input type="text"
                                    class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="additional"
                                    name="additional"
                                    value="{{ old('additional', $appointment->additional) ?: 'N/A' }}" disabled>
                            </div>

                            <!-- Doctor -->
                            <div class="mb-1">
                                <label for="doctor" class="form-label font-medium text-gray-700 block mb-2">Doctor</label>
                                <select class="form-select block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="doctor" name="doctor" disabled>
                                    <option value="Dr. Jane Smith" {{ old('doctor', $appointment->doctor) == 'Dr. Jane Smith' ? 'selected' : '' }}>Dr. Jane Smith</option>
                                    <option value="Dr. John Doe" {{ old('doctor', $appointment->doctor) == 'Dr. John Doe' ? 'selected' : '' }}>Dr. John Doe</option>
                                </select>
                            </div>

                            <!-- Gender -->
                            <div class="mb-1">
                                <label for="gender" class="form-label font-medium text-gray-700 block mb-2">Gender</label>
                                <select class="form-select block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="gender" name="gender" disabled>
                                    <option value="Male" {{ old('gender', $appointment->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $appointment->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $appointment->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <!-- Marital Status -->
                            <div class="mb-1">
                                <label for="maritalStatus" class="form-label font-medium text-gray-700 block mb-2">Marital Status</label>
                                <select class="form-select block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="maritalStatus" name="marital_status" disabled>
                                    <option value="Single" {{ old('marital_status', $appointment->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('marital_status', $appointment->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('marital_status', $appointment->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                </select>
                            </div>

                            <!-- Contact Number -->
                            <div class="mb-1">
                                <label for="contactNumber" class="form-label font-medium text-gray-700 block mb-2">Contact Number</label>
                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="contactNumber" name="contact_number" value="{{ old('contact_number', $appointment->contact_number) }}" disabled>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-1">
                                <label for="emailAddress" class="form-label font-medium text-gray-700 block mb-2">Email Address</label>
                                <input type="email" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="emailAddress" name="email_address" value="{{ old('email_address', $appointment->email_address) }}" disabled>
                            </div>

                            <!-- Complete Address -->
                            <div class="mb-1">
                                <label for="completeAddress" class="form-label font-medium text-gray-700 block mb-2">Complete Address</label>
                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="completeAddress" name="complete_address" value="{{ old('complete_address', $appointment->complete_address) }}" disabled>
                            </div>

                            <!-- Notes -->
                            <div class="col-span-1 md:col-span-2 mb-1">
                                <label for="notes" class="form-label font-medium text-gray-700 block mb-2">Notes</label>
                                <textarea class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="notes" name="notes" disabled>{{ old('notes', $appointment->notes) }}</textarea>
                            </div>
                        </div>
                    </form>

                    <div>
                        <div class='my-3'>
                            <span class='font-medium text-[#0074C8]'>
                                Medical Billing Invoice
                            </span>
                        </div>

                        <div>
                            <div class='flex gap-4'> <!-- Added gap for spacing -->
                                <div class="flex-1 mb-1"> <!-- Added flex-1 for growth -->
                                    <label for="appointmentDate" class="form-label font-medium text-gray-700 block mb-2">Appointment Date</label>
                                    <input type="date" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="appointmentDate" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" disabled>
                                </div>
                                <div class="flex-1 mb-1"> <!-- Added flex-1 for growth -->
                                    <label class="form-label font-medium text-gray-700 block mb-2">Bill Type</label>
                                    <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value='Cash Bill' disabled>
                                </div>
                            </div>
                        </div>

                        <div class='mt-4'>
                            <form action="{{ route('cashierinvoice.items', $appointment->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <table class="w-full text-left border-collapse">
                                    <!-- <div class="flex justify-end mt-4 gap-2 mb-3">
                                        <button type="button" id="addRow" class="bg-[#0074C8] text-white rounded-lg px-3 py-2">
                                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                                        </button>
                                    </div> -->
                                    <div class="font-medium flex text-[14px] justify-center items-center gap-1 border-[1px] my-2 px-2 rounded-full py-2 text-center w-[200px] 
            {{ empty($appointment->descriptions) ? 'bg-red-100 border-red-700 text-red-700' : 'bg-green-100 border-green-700 text-green-700' }}">
                                        <i class="fa-solid fa-circle fa-2xs"></i>
                                        {{ empty($appointment->descriptions) ? 'NOT PAID' : 'PAID' }}
                                    </div>
                                    <thead>
                                        <div class="flex justify-center items-center">
                                            <div class="p-2">
                                                <span class="font-bold">ID Number</span>
                                                <input value="{{ $appointment->id_number }}" type="text" id="idNumber" name="id_number" class="mt-2 w-80 border border-gray-300 rounded-lg p-2">
                                            </div>

                                            <div class="p-2">
                                                <span class="font-bold">ID Type</span>
                                                <select id="idType" name="id_type" class="mt-2 w-80 border border-gray-300 rounded-lg p-2">
                                                    <option value="">Select ID Type</option>
                                                    <option value="PWD" {{ isset($appointment) && $appointment->id_type == 'PWD' ? 'selected' : '' }}>PWD (Person with Disability)</option>
                                                    <option value="Senior Citizen" {{ isset($appointment) && $appointment->id_type == 'Senior Citizen' ? 'selected' : '' }}>Senior Citizen</option>
                                                </select>
                                            </div>
                                            <div class="p-2">
                                                <span class="font-bold">Add Discount</span>
                                                <select name="discount" id="discountSelect" class="mt-2 w-80 border border-gray-300 rounded-lg p-2">
                                                    <option value="0"
                                                        {{ (old('discount') ?? $appointment->discount ?? ($appointment->id_type == 'PWD' || $appointment->id_type == 'Senior Citizen' ? 20 : 0)) == 0 ? 'selected' : '' }}>
                                                        0%
                                                    </option>
                                                    <option value="50"
                                                        {{ (old('discount') ?? $appointment->discount ?? ($appointment->id_type == 'PWD' || $appointment->id_type == 'Senior Citizen' ? 20 : 0)) == 50 ? 'selected' : '' }}>
                                                        50%
                                                    </option>
                                                    <option value="40"
                                                        {{ (old('discount') ?? $appointment->discount ?? ($appointment->id_type == 'PWD' || $appointment->id_type == 'Senior Citizen' ? 20 : 0)) == 40 ? 'selected' : '' }}>
                                                        40%
                                                    </option>
                                                    <option value="30"
                                                        {{ (old('discount') ?? $appointment->discount ?? ($appointment->id_type == 'PWD' || $appointment->id_type == 'Senior Citizen' ? 20 : 0)) == 30 ? 'selected' : '' }}>
                                                        30%
                                                    </option>
                                                    <option value="20"
                                                        {{ (old('discount') ?? $appointment->discount ?? ($appointment->id_type == 'PWD' || $appointment->id_type == 'Senior Citizen' ? 20 : 0)) == 20 ? 'selected' : '' }}>
                                                        20%
                                                    </option>
                                                    <option value="10"
                                                        {{ (old('discount') ?? $appointment->discount ?? ($appointment->id_type == 'PWD' || $appointment->id_type == 'Senior Citizen' ? 20 : 0)) == 10 ? 'selected' : '' }}>
                                                        10%
                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                        <tr>
                                            <th class="p-2 border-t">Description</th>
                                            <th class="p-2 border-t">Qty</th>
                                            <th class="p-2 border-t">Amount</th>
                                            <!-- <th class="p-2 border-t">Action</th> A dded Action column for Add/Remove buttons -->
                                        </tr>
                                    </thead>
                                    <tbody id="invoiceTableBody">
                                        <tr>
                                            <td style="width: 33%;" class='pr-6 mb-2'>
                                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    name="descriptions[]" value="{{ $appointment->visit_type }}">
                                            </td>
                                            <td style="width: 15%;" class='mb-2'>
                                                <input type="number" name="qty[]" value="1" min="1" readonly class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-200 cursor-not-allowed">
                                            </td>

                                            <td style="width: 15%;" class='mb-2'>
                                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    name="amount[]" value="{{ json_decode($appointment->amount)[0] ?? '0'}}" readonly>
                                            </td>
                                        </tr>

                                        <!-- Add input for 'additional' if not empty -->
                                        @if (!empty($appointment->additional))
                                        <tr>
                                            <td style="width: 33%;" class='pr-6 mb-2'>
                                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    name="descriptions[]" value="{{ $appointment->additional }}">
                                            </td>
                                            <td style="width: 15%;" class='mb-2'>
                                                <input type="number" name="qty[]" value="1" min="1" readonly class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-200 cursor-not-allowed">
                                            </td>

                                            <td style="width: 15%;" class='mb-2'>
                                                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    name="amount[]" value="300" readonly>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>

                                </table>

                                <div class="mt-3 w-full flex gap-2">
                                    <button type="submit" class="block w-full rounded-md bg-[#0074C8] text-white px-3 py-2">Save</button>
                                    <a href="{{ route('invoiceCashier.print', $appointment->id) }}" class="block w-full rounded-md bg-[#0074C8] text-white text-center px-3 py-2">Print</a>
                                </div>
                            </form>
                        </div>

                        <!-- <script>
                            document.getElementById('addRow').addEventListener('click', function() {
                                var tableBody = document.getElementById('invoiceTableBody');
                                var newRow = document.createElement('tr');

                                newRow.innerHTML = `
            <td style="width: 33%;" class='pr-6 mb-2'>
                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="descriptions[]">
            </td>
            <td style="width: 15%;" class='mb-2'>
                <input type="number" name="qty[]" value="1" min="1" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </td>
            <td style="width: 15%;" class='mb-2'>
                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="amount[]">
            </td>
            <td style="width: 10%;">
                <button type="button" class="removeRow bg-red-500 text-white rounded-lg px-3 py-1">
                    <i class="fa-solid fa-x" style="color: #ffffff;"></i>
                </button>
            </td>
        `;

                                tableBody.appendChild(newRow);

                                // Add event listener to new remove button
                                newRow.querySelector('.removeRow').addEventListener('click', function() {
                                    newRow.remove();
                                });
                            });

                            // Event listener for existing removeRow buttons (if any)
                            document.querySelectorAll('.removeRow').forEach(button => {
                                button.addEventListener('click', function() {
                                    this.closest('tr').remove();
                                });
                            });
                        </script> -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const idTypeSelect = document.getElementById('idType');
                                const discountSelect = document.getElementById('discountSelect');

                                idTypeSelect.addEventListener('change', function() {
                                    const selectedId = idTypeSelect.value;

                                    // Automatically set 20% discount for PWD or Senior Citizen
                                    if (selectedId === 'PWD' || selectedId === 'Senior Citizen') {
                                        discountSelect.value = '20';
                                    } else {
                                        discountSelect.value = ''; // reset to 0% if no special ID
                                    }
                                });
                            });
                        </script>

                        @endsection