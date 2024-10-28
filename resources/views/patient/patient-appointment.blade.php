@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg p-10">
        <h1 class="font-medium text-2xl border-b pb-3">Book Appointment</h1>

        @include('patient.navigation')

        <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST"> <!-- Set the form action to your route -->
            @csrf <!-- Include CSRF token for security -->

            <div class="mt-5">
                <div class="flex gap-16">
                    <div>
                        <h2 class="font-medium text-xl mb-3">Select Date</h2>
                        <div id="calendar" class="w-[600px]"></div>
                        <input type="hidden" name="selected_date" id="selected_date" required> <!-- Hidden input for selected date -->
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h2 class="font-medium text-xl mb-3">Select Time</h2>
                        <div class="flex gap-4">
                            <div class="bg-white shadow-md flex-grow">
                                <div class="text-center border-b p-6">
                                    <span class="text-xl font-medium">Morning</span>
                                </div>
                                <div class="p-8 text-center flex flex-col gap-4">
                                    @foreach (['9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM'] as $time)
                                        <div class="time-slot py-2 cursor-pointer transition duration-200 text-[20px] rounded-md" onclick="setTime('{{ $time }}', this)">{{ $time }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-white shadow-md flex-grow">
                                <div class="text-center border-b p-6">
                                    <span class="text-xl font-medium">Afternoon</span>
                                </div>
                                <div class="p-8 text-center flex flex-col gap-4">
                                    @foreach (['1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM'] as $time)
                                        <div class="time-slot py-2 cursor-pointer transition duration-200 text-[20px] rounded-md" onclick="setTime('{{ $time }}', this)">{{ $time }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="selected_time" id="selected_time" required> <!-- Hidden input for selected time -->
                    </div>
                </div>

                <div class="my-6">
                    <h2 class="font-medium text-xl mb-3">Select Doctor</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach ($users as $user)
                            <div class="doctor-slot bg-white p-4 shadow w-full flex items-center gap-4 cursor-pointer" onclick="setDoctor('{{ $user->id }}', '{{ $user->name }}', this)">
                                <div>
                                    <i class="fa-solid fa-circle-user text-[40px]" style="color: #0074cb;"></i>
                                </div>
                                <div>
                                    <span class='font-medium'>Dr. {{ $user->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="selected_doctor" id="selected_doctor" required> <!-- Hidden input for selected doctor -->
                </div>

                <div>
                    <button type="submit" class="w-full h-12 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">Next</button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            validRange: {
                start: today // Disable past dates
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch(`/monthly-slots?month=${fetchInfo.startStr.substring(0, 7)}`)
                    .then(response => response.json())
                    .then(data => {
                        const events = data.map(slot => ({
                            title: slot.available_slots > 0 ? `${slot.available_slots} Slot${slot.available_slots > 1 ? 's' : ''}` : 'Fully Booked',
                            start: slot.date,
                            className: slot.status  
                        }));
                        successCallback(events);
                    })
                    .catch(error => {
                        console.error('Error fetching slot data:', error);
                        failureCallback(error);
                    });
            },
            dateClick: function(info) {
                document.getElementById('selected_date').value = info.dateStr; // Set the hidden input for the selected date
                highlightDate(info.dateStr); // Highlight selected date
            }
        });

        calendar.render();
    });

    function highlightDate(date) {
        const dateElements = document.querySelectorAll('.fc-day'); // Select all date elements in the calendar
        dateElements.forEach(el => {
            if (el.dataset.date === date) {
                el.classList.add('bg-blue-500', 'text-white'); // Highlight the selected date
            } else {
                el.classList.remove('bg-blue-500', 'text-white'); // Remove highlight from unselected dates
            }
        });
    }

    function setTime(time, element) {
        document.getElementById('selected_time').value = time; // Set the hidden input for the selected time
        
        // Remove active class from all time slots and add active class to the clicked time slot
        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => {
            slot.classList.remove('bg-blue-500', 'text-white'); // Remove active styles
        });
        element.classList.add('bg-blue-500', 'text-white'); // Add active styles to the selected time slot
    }

    function setDoctor(doctorId, doctorName, element) {
        document.getElementById('selected_doctor').value = doctorId; // Set the hidden input for the selected doctor
        
        // Remove active class from all doctor slots and add active class to the clicked doctor slot
        const doctorSlots = document.querySelectorAll('.doctor-slot');
        doctorSlots.forEach(slot => {
            slot.classList.remove('bg-blue-100', 'text-white'); // Remove active styles
        });
        element.classList.add('bg-blue-100', 'text-white'); // Add active styles to the selected doctor slot
    }

    // Validate form before submission
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        const date = document.getElementById('selected_date').value;
        const time = document.getElementById('selected_time').value;
        const doctor = document.getElementById('selected_doctor').value;

        if (!date || !time || !doctor) {
            e.preventDefault(); // Prevent form submission
            alert('Please select a date, time, and doctor before proceeding.');
        }
    });
</script>

<style>
    /* Style events based on their status */
    .fc-event.available {
        background-color: #00FF00; /* Green */
        border-color: #00FF00;
    }

    .fc-event.fully_booked {
        background-color: #FF0000; /* Red */
        border-color: #FF0000;
    }

    .fc-event.partially_booked {
        background-color: #007BFF; /* Blue */
        border-color: #007BFF;
    }
</style>
@endsection
