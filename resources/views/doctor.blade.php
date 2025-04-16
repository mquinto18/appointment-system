@extends('layouts.doctor')

@section('title', 'Doctor Dashboard')

@section('contents')
<div class='flex justify-between items-center'>
    <div>
        <h1 class='font-medium text-2xl ml-3'>
            Doctor Dashboard
        </h1>
    </div>
</div>

<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-20'>
    <div class='grid grid-cols-3 gap-3'>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Upcoming Appointments</h1>
                <i class="fa-solid fa-user text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalUsers }}</h1> <!-- Display total users here -->
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Appointments</h1>
                <i class="fa-regular fa-calendar-days text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalAppointment }}</h1>

            <!-- <div class="flex justify-end">
                <a href="{{ route('appointment') }}">
                    <i class="fa-solid fa-angles-right text-[30px]"></i>
                </a>
            </div> -->
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Completed</h1>
                <i class="fa-solid fa-check-to-slot text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalCompleted }}</h1>

            <div class="flex justify-end">
                <a href="{{ route('doctorAppointment') }}">
                    <i class="fa-solid fa-angles-right text-[30px]"></i>
                </a>
            </div>
        </div>
        <!-- <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Earning</h1>
                <i class="fa-solid fa-peso-sign text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalAmount }}</h1>
        </div> -->
    </div>

    <div class='bg-white shadow-md  px-6 py-4 rounded-md my-3'>
        <!-- <div>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Patient Summary</h1>
            </div>
        
            <div class="mt-5 flex justify-center items-center" style="height: 450px;">
                <canvas id="patientSummaryChart" style="max-width: 450px; max-height: 450px;"></canvas>
            </div>
        </div> -->

        @if($ongoingPatient)
        <div class="shadow-md px-6 py-4 rounded-lg my-3" style="background-color: rgba(0, 116, 200, 0.05);">
            <div class='mb-5'>
                <h1 class='font-medium text-[24px] text-blue-700'>On Going Patient Details</h1>
            </div>
            <div>
                <div class=''>
                    <div>
                        <h1 class='font-bold text-[20px] text-gray-700'>{{ $ongoingPatient->first_name }} {{ $ongoingPatient->last_name }}</h1>
                        <h1 class='text-[15px] text-gray-500'>{{ $ongoingPatient->visit_type }}</h1>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-20">
                    <div class="border-b border-gray-400 pb-3">
                        <h1 class='text-[18px] font-bold text-gray-700'>Birthday</h1>
                        <h1 class='font-medium text-[15px] text-gray-600'>{{ $ongoingPatient->date_of_birth }}</h1>
                    </div>
                    <div class="border-b border-gray-400 pb-3">
                        <h1 class='text-[18px] font-bold text-gray-700'>Age</h1>
                        <h1 class='font-medium text-[15px] text-gray-600'>{{ \Carbon\Carbon::parse($ongoingPatient->date_of_birth)->age }}</h1>
                    </div>
                    <div class="border-b border-gray-400 pb-3">
                        <h1 class='text-[18px] font-bold text-gray-700'>Gender</h1>
                        <h1 class='font-medium text-[15px] text-gray-600'>{{ $ongoingPatient->gender }}</h1>
                    </div>

                    <div class="border-b border-gray-400 pb-3">
                        <h1 class='text-[18px] font-bold text-gray-700'>Phone Number</h1>
                        <h1 class='font-medium text-[15px] text-gray-600'>{{ $ongoingPatient->contact_number }}</h1>
                    </div>
                    <div class="border-b border-gray-400 pb-3">
                        <h1 class='text-[18px] font-bold text-gray-700'>Email Address</h1>
                        <h1 class='font-medium text-[15px] text-gray-600'>{{ $ongoingPatient->email_address }}</h1>
                    </div>
                    <div class="border-b border-gray-400 pb-3">
                        <h1 class='text-[18px] font-bold text-gray-700'>Registered Date</h1>
                        <h1 class='font-medium text-[15px] text-gray-600'>{{ $ongoingPatient->created_at->format('F d, Y') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="shadow-md px-6 py-4 rounded-lg my-3" style="background-color: rgba(0, 116, 200, 0.05);">
            <div class='mb-5'>
                <h1 class='font-medium text-[24px] text-blue-700'>On Going Patient Details</h1>
            </div>
            <div class="text-center">
                <h1 class='font-medium text-[18px] text-gray-700'>No ongoing appointments at the moment.</h1>
            </div>
        </div>
        @endif

    </div>

    <div class="flex gap-3">
        <!-- Patients History -->
        <div class="flex-1 bg-white shadow-md px-6 py-4 rounded-md my-3">
            <div>
                <div class="font-medium border-b py-3">
                    Patients History
                </div>
                <table class="min-w-full bg-white border mt-3">
                    <thead>
                        <tr class="text-left">
                            <th class="py-3 px-4 border-b">ID</th>
                            <th class="py-3 px-4 border-b">Patients Name</th>
                            <th class="py-3 px-4 border-b">Birthday</th>
                            <th class="py-3 px-4 border-b">Age</th>
                            <th class="py-3 px-4 border-b">Gender</th>
                            <th class="py-3 px-4 border-b">Visit Type</th>
                            <th class="py-3 px-4 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                        <tr>
                            <td class="py-3 px-4 border-b">{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                            <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->date_of_birth)->format('F j, Y') }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->date_of_birth ? \Carbon\Carbon::parse($appointment->date_of_birth)->age : 'N/A' }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->gender }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                            <td class="py-3 px-4 border-b">
                                <div class="font-medium flex text-[12px] justify-center items-center gap-1 border-[1px] px-2 rounded-full text-center 
                                    @if($appointment->status === 'pending') bg-orange-100 border-orange-700 
                                    @elseif($appointment->status === 'approved') bg-green-100 border-green-700 
                                    @elseif($appointment->status === 'rejected') bg-red-100 border-red-700 
                                    @elseif($appointment->status === 'completed') bg-blue-100 border-blue-700 @endif">
                                    <i class="fa-solid fa-circle fa-2xs"
                                        @if($appointment->status === 'pending') style="color: #c05621"
                                        @elseif($appointment->status === 'approved') style="color: #38a169"
                                        @elseif($appointment->status === 'rejected') style="color: #e53e3e"
                                        @elseif($appointment->status === 'completed') style="color: #3182ce" @endif></i>
                                    {{ strtoupper($appointment->status) }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-3 px-4 border-b text-center">No patient history</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Patients Review -->
        <div class="w-1/3 bg-white shadow-md px-6 py-4 rounded-md my-3">
            <div class="font-medium border-b py-3">
                Patients Review
            </div>
            <div class="flex justify-center items-center h-[400px]">
                <canvas id="ratingChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('patientSummaryChart').getContext('2d');
    const patientSummaryChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['New Patients', 'Old Patients'],
            datasets: [{
                label: 'Patient Summary',
                data: [{
                    {
                        $newAppointments
                    }
                }, {
                    {
                        $oldAppointments
                    }
                }],
                backgroundColor: [
                    '#007bff', // Blue for new patients
                    '#FFA500' // Yellow for old patients
                ],

            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    const ctxRating = document.getElementById('ratingChart').getContext('2d');
    const ratingsData = @json($ratingsData); // Inject PHP variable as JSON

    const ratingChart = new Chart(ctxRating, {
        type: 'bar', // Bar chart
        data: {
            labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'], // Rating labels
            datasets: [{
                label: 'Number of Reviews',
                data: [ratingsData[1], ratingsData[2], ratingsData[3], ratingsData[4], ratingsData[5]], // Use ratingsData for chart
                backgroundColor: [
                    '#f56565', // Red for 1 Star
                    '#ed8936', // Orange for 2 Stars
                    '#ecc94b', // Yellow for 3 Stars
                    '#48bb78', // Green for 4 Stars
                    '#4299e1' // Blue for 5 Stars
                ],
                borderColor: [
                    '#e53e3e', // Border red
                    '#dd6b20', // Border orange
                    '#d69e2e', // Border yellow
                    '#38a169', // Border green
                    '#3182ce' // Border blue
                ],
                borderWidth: 1 // Optional: Add a border around bars
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y', // Switch to horizontal bars
            plugins: {
                legend: {
                    display: false // Hide legend for simplicity
                }
            },
            scales: {
                x: {
                    beginAtZero: true, // Ensure the x-axis starts at 0
                    title: {
                        display: true,
                        text: 'Number of Reviews'
                    },
                    ticks: {
                        precision: 0, // Remove decimal places
                        stepSize: 1, // Step only by whole numbers
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                },
                y: {
                    grid: {
                        display: false // Remove horizontal grid lines
                    },
                    title: {
                        display: true,
                        text: 'Rating'
                    }
                }
            }
        }
    });
</script>



@endsection