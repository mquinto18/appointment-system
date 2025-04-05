@extends('layouts.app')

@section('title', 'Admin')

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
        <div class=''>
            <span class='font-medium text-[#0074C8]'>Patient Details</span>
        </div>


        <div class="">
            <form action="{{ route('appointments.followUpPost', $appointment->id) }}" method="POST">
                @csrf

                <div class="flex flex-col lg:flex-row gap-8 mt-5">
                    <!-- Calendar Section -->
                    <div class="w-full lg:w-[50%]">
                        <h2 class="font-medium text-xl mb-3">Select Date</h2>
                        <div id="calendar" class="w-full max-w-[700px]"></div>
                        <!-- Hidden input for selected date -->
                        <input type="hidden" name="selected_date" id="selected_date" value="{{ $appointment->appointment_date }}">
                    </div>

                    <!-- Appointment Details Section -->
                    <div class="w-full lg:w-[50%]">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="transaction_number" class="font-medium">Transaction Number</label>
                                <input type="text" id="transaction_number" name="transaction_number" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->transaction_number }}" readonly disabled>
                            </div>
                            <div>
                                <label for="appointment_time" class="font-medium">Time</label>
                                <select id="appointment_time" name="appointment_time" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
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

                            <div>
                                <label for="first_name" class="font-medium">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->first_name }}">
                            </div>
                            <div>
                                <label for="last_name" class="font-medium">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->last_name }}">
                            </div>
                            <div>
                                <label for="visit_type" class="font-medium">Visit Type</label>
                                <input type="text" id="visit_type" name="visit_type" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->visit_type }}">
                            </div>
                            <div>
                                <label for="visit_type" class="font-medium">Doctor</label>
                                <input type="text" id="doctor" name="doctor" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->doctor }}">
                            </div>
                            <div>
                                <label for="mobile_number" class="font-medium">Mobile Number</label>
                                <input type="text" id="mobile_number" name="mobile_number" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->contact_number }}">
                            </div>
                            <div>
                                <label for="email_address" class="font-medium">Email Address</label>
                                <input type="email" id="email_address" name="email_address" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $appointment->email_address }}">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium px-5 py-3 rounded-md">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var today = new Date();
    var todayString = today.toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
    var preselectedDate = document.getElementById('selected_date').value; // Pre-selected date from the hidden input

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        validRange: {
            start: todayString // Disable past dates
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch(`/admin/monthly-slots?month=${fetchInfo.startStr.substring(0, 7)}`)
                .then(response => response.json())
                .then(data => {
                    const events = data.map(slot => ({
                        title: slot.status === 'fully_booked' ? 'Fully Booked' : `${slot.available_slots} Slot${slot.available_slots > 1 ? 's' : ''} Available`,
                        start: slot.start,
                        className: slot.status, // Set status to apply different styles
                        available_slots: slot.available_slots,
                        status: slot.status,
                        date: slot.date, // Add date for comparison
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error fetching slot data:', error);
                    failureCallback(error);
                });
        },
        dateClick: function (info) {
            const selectedDate = info.dateStr;

            // Prevent selecting the current date
            if (selectedDate === todayString) {
                alert('You cannot select today\'s date.');
                return;
            }

            fetch(`/admin/monthly-slots?month=${selectedDate.substring(0, 7)}`)
                .then(response => response.json())
                .then(events => {
                    const event = events.find(e => e.date === selectedDate);
                    if (event && event.status === 'fully_booked') {
                        alert('This date is fully booked.');
                    } else {
                        document.getElementById('selected_date').value = selectedDate; // Set the hidden input for the selected date
                        highlightDate(selectedDate); // Highlight selected date
                    }
                });
        },
        datesSet: function () {
            // Highlight the preselected date when the calendar view changes
            if (preselectedDate) {
                highlightDate(preselectedDate);
            }
        }
    });

    calendar.render();

    // Highlight the pre-selected date on load
    if (preselectedDate) {
        highlightDate(preselectedDate);
    }
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

</script>
<style>
    /* Style events based on their status */
    .fc-event.available {
        background-color: #07CC62;
        /* Green */
        border-color: #07CC62;
    }

    .fc-event.fully_booked {
        background-color: #FF0000;
        /* Red */
        border-color: #FF0000;
        pointer-events: none;
        /* Disable clicking */
        opacity: 0.5;
        /* Visual indication that the date is fully booked */
    }
</style>

@endsection