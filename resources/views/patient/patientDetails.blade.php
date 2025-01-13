@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg">
        <div class="py-5 px-10">
            <h1 class="font-medium text-2xl border-b pb-3">Book Appointment</h1>

            @include('patient.navigation')

            <form id="appointmentForm" action="{{ route('appointments.storePatientDetails') }}" method="POST">
    @csrf

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
                    <input type="radio" name="gender" value="male" id="male" class="mr-2" required>
                    <label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" name="gender" value="female" id="female" class="mr-2" required>
                    <label for="female">Female</label>
                </div>
            </div>
        </div>

        <!-- Visit Type (Full Width) -->
        <div class="col-span-2">
            <label for="visit_type" class="block text-sm font-medium text-gray-700 mb-2">Visit Type</label>
            <div id="visit_type" class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                <button type="button" 
                    class="block w-full rounded-md border border-gray-300 p-4 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    data-value="Medical Consultation" 
                    data-amount="600">
                    <span class="block font-medium">Medical Consultation (Adult)</span>
                    <span class="block text-sm text-gray-500">₱600/Consultation</span>
                </button>
                <button type="button" 
                    class="block w-full rounded-md border border-gray-300 p-4 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    data-value="Pediatric Consultation" 
                    data-amount="600">
                    <span class="block font-medium">Pediatric Consultation</span>
                    <span class="block text-sm text-gray-500">₱600/Consultation</span>
                </button>
                <button type="button" 
                    class="block w-full rounded-md border border-gray-300 p-4 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    data-value="Pediatric Ears, Nose and Throat" 
                    data-amount="599">
                    <span class="block font-medium">Pediatric Ears, Nose, and Throat</span>
                    <span class="block text-sm text-gray-500">₱599/Consultation</span>
                </button>
                <button type="button" 
                    class="block w-full rounded-md border border-gray-300 p-4 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    data-value="Adult Ears, Nose, and Throat" 
                    data-amount="699">
                    <span class="block font-medium">Adult Ears, Nose, and Throat</span>
                    <span class="block text-sm text-gray-500">₱699/Consultation</span>
                </button>
                <button type="button" 
                    class="block w-full rounded-md border border-gray-300 p-4 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    data-value="Minor Suturing" 
                    data-amount="699">
                    <span class="block font-medium">Minor Suturing</span>
                    <span class="block text-sm text-gray-500">₱699/Consultation</span>
                </button>
                <button type="button" 
                    class="block w-full rounded-md border border-gray-300 p-4 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    data-value="Wound Dressing" 
                    data-amount="500">
                    <span class="block font-medium">Wound Dressing</span>
                    <span class="block text-sm text-gray-500">₱500/Consultation</span>
                </button>
                <!-- Add the remaining buttons similarly -->
            </div>
            <input type="hidden" name="visit_type" id="selected_visit_type" required>
            <input type="hidden" name="amount" id="selected_visit_amount" required>
        </div>


        <!-- Medical Certificate -->
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="medical_certificate" name="medical_certificate" value="Medical Certificate">
                <label class="form-check-label" for="medical_certificate">
                    Need Medical Certificate  / ₱300
                </label>
            </div>
        </div>

        <!-- Privacy Policy Checkbox -->
        <div class="col-span-2 flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50" required="">
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="font-light text-gray-500">
                    I agree that I have read the
                    <a href="#" class="font-medium text-[#0074C8] underline" onclick="toggleModal(true)">privacy policy</a>.
                </label>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="mt-6">
        <button type="submit" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold hover:bg-blue-600 hover:text-white transition duration-200">Next</button>
    </div>
</form>


    </div>
</div>
<div>
    <!-- Privacy Policy Modal -->
    <div id="policyModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white w-11/12 md:w-1/2 lg:w-1/3 rounded-lg p-6 shadow-lg relative transform transition-transform duration-300 scale-95">
            <h2 class="text-xl font-semibold mb-4">Privacy Policy</h2>
            <p class="text-gray-600 mb-6">
                St. Benedict Medical Clinic & Pharmacy is committed to safeguarding the privacy of our users. This Privacy Policy outlines how we collect, use,
                store, and protect your personal information when you use our web-based online clinic appointment system.
            </p>
            <!-- first -->
            <div>
                <div class="bg-gradient-to-t from-[#151A5C] to-[#0074C8] py-3 px-4 flex justify-between items-center cursor-pointer" onclick="toggleContent(1)">
                    <span class="text-white font-medium">What information do we collect about you?</span>
                    <i class="fa-solid fa-plus text-white transition-transform transform" id="icon1"></i>
                </div>

                <div id="content1" class="bg-white shadow-md py-3 px-4 text-sm transition-all max-h-0 overflow-hidden opacity-0">
                    <div class="pb-3">
                        <span class="font-medium">We collect the following types of information when you interact with our online clinic appointment system:</span>
                    </div>

                    <ul class="list-disc pl-5">
                        <li><span class="font-medium">Personal Information:</span> When you register or make an appointment, we collect personal information such as your name, contact information, date of birth, address, and health-related details necessary for appointment scheduling.</li>
                        <li><span class="font-medium">Health Information:</span> Information about your medical history, current symptoms, prescriptions, and appointment history may be collected to facilitate healthcare services.</li>
                        <li><span class="font-medium">Appointment Data:</span> Details regarding the dates, times, and purposes of your appointments.</li>
                    </ul>
                </div>
            </div>

            <!-- second -->
            <div>
                <div class="bg-gradient-to-t from-[#151A5C] to-[#0074C8] py-3 px-4 flex justify-between items-center cursor-pointer" onclick="toggleContent(2)">
                    <span class="text-white font-medium">How do we use your information?</span>
                    <i class="fa-solid fa-plus text-white transition-transform transform" id="icon2"></i>
                </div>

                <div id="content2" class="bg-white shadow-md py-3 px-4 text-sm transition-all max-h-0 overflow-hidden opacity-0">
                    <div class="pb-3">
                        <span class="font-medium">We use the collected information to:</span>
                    </div>

                    <ul class="list-disc pl-5">
                        <li><span class="font-medium">Facilitate online appointments and manage the appointment process.</li>
                        <li><span class="font-medium">Health Information:</span> Information about your medical history, current symptoms, prescriptions, and appointment history may be collected to facilitate healthcare services.</li>
                        <li><span class="font-medium">Generate documents such as prescriptions, medical certificates, and billing invoices.</li>
                        <li><span class="font-medium">Improve the functionality and user experience of our online system.</li>
                    </ul>
                </div>
            </div>

            <!-- third -->
            <div>
                <div class="bg-gradient-to-t from-[#151A5C] to-[#0074C8] py-3 px-4 flex justify-between items-center cursor-pointer" onclick="toggleContent(3)">
                    <span class="text-white font-medium">To whom do we disclose your information?</span>
                    <i class="fa-solid fa-plus text-white transition-transform transform" id="icon3"></i>
                </div>

                <div id="content3" class="bg-white shadow-md py-3 px-4 text-sm transition-all max-h-0 overflow-hidden opacity-0">
                    <div class="pb-3">
                        <span class="font-medium">We do not sell, rent, or trade your personal information. However, we may share your data with the following parties:</span>
                    </div>

                    <ul class="list-disc pl-5">
                        <li>Healthcare Providers: Your personal and health information may be shared with your assigned doctors, specialists, or other healthcare professionals involved in your care.</li>
                        <li>Payment Processors: For billing and payment transactions.</li>
                        <li>Third-Party Service Providers: We may share information with trusted third-party services (e.g., IT support) under strict confidentiality agreements, where necessary for system maintenance or improvements.</li>
                    </ul>
                </div>
            </div>

            <!-- fourth -->
            <div>
                <div class="bg-gradient-to-t from-[#151A5C] to-[#0074C8] py-3 px-4 flex justify-between items-center cursor-pointer" onclick="toggleContent(4)">
                    <span class="text-white font-medium">What do we do to keep your information secure?</span>
                    <i class="fa-solid fa-plus text-white transition-transform transform" id="icon4"></i>
                </div>

                <div id="content4" class="bg-white shadow-md py-3 px-4 text-sm transition-all max-h-0 overflow-hidden opacity-0">
                    <div class="pb-3">
                        <span class="font-medium">We employ a variety of security measures to protect your personal and medical information, including:</span>
                    </div>

                    <ul class="list-disc pl-5">
                        <li>Data encryption (both in transit and at rest).</li>
                        <li>Secure access controls and user authentication processes.</li>
                        <li>Regular system audits and vulnerability assessments.</li>
                        <li>Restricted access to sensitive data, limited to authorized personnel only.</li>
                    </ul>
                </div>
            </div>

            <!-- fifth -->
            <div>
                <div class="bg-gradient-to-t from-[#151A5C] to-[#0074C8] py-3 px-4 flex justify-between items-center cursor-pointer" onclick="toggleContent(5)">
                    <span class="text-white font-medium">Cookies and Tracking</span>
                    <i class="fa-solid fa-plus text-white transition-transform transform" id="icon5"></i>
                </div>

                <div id="content5" class="bg-white shadow-md py-3 px-4 text-sm transition-all max-h-0 overflow-hidden opacity-0">

                    <span>Our system uses cookies to improve user experience, track user preferences, and optimize system performance. You can control cookie settings through your browser, but disabling cookies may affect the system’s functionality.</span>
                </div>
            </div>
            <button onclick="toggleModal(false)" class="absolute top-1 right-3 text-[30px] text-gray-600 hover:text-gray-800">&times;</button>
        </div>

        
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
    function toggleModal(show) {
        const modal = document.getElementById('policyModal');
        if (show) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        } else {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
        }
    }

    function toggleContent(id) {
        const content = document.getElementById('content' + id);
        const icon = document.getElementById('icon' + id);

        content.classList.toggle('max-h-0');
        content.classList.toggle('opacity-0');
        content.classList.toggle('max-h-[1000px]'); // Adjust this value based on content size
        content.classList.toggle('opacity-100');

        // Toggle icon rotation
        icon.classList.toggle('rotate-45'); // Rotates the icon when content is expanded
    }
    
    document.querySelectorAll('[data-value]').forEach(button => {
    button.addEventListener('click', () => {
        // Remove the background color from all buttons
        document.querySelectorAll('[data-value]').forEach(btn => {
            btn.classList.remove('bg-indigo-100', 'border-indigo-500');
        });

        // Add the background color to the selected button
        button.classList.add('bg-indigo-100', 'border-indigo-500');

        const visitType = button.getAttribute('data-value');
        const visitAmount = button.querySelector('span.text-gray-500').textContent.replace(/[^\d]/g, ''); // Extract numeric value
        
        // Store the amount as a number in an array
        const jsonData = JSON.stringify([parseInt(visitAmount)]); // Convert amount to an array

        // Set the JSON data in the hidden input fields
        document.getElementById('selected_visit_type').value = visitType;
        document.getElementById('selected_visit_amount').value = jsonData;
    });

});
</script>

@endsection