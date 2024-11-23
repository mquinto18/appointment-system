@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('contents')
<div class='flex justify-between items-center'>
    <div>
        <h1 class='font-medium text-2xl ml-3'>
            Dashboard
        </h1>
    </div>
</div>

<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-20'>
    <div class='grid grid-cols-4 gap-3'>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Users</h1>
                <i class="fa-solid fa-user text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalUsers }}</h1> <!-- Display total users here -->

            <div class="flex justify-end">
                <a href="{{ route('user') }}">
                 <i class="fa-solid fa-angles-right text-[30px]"></i>
                </a>
            </div>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Appointments</h1>
                <i class="fa-regular fa-calendar-days text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalAppointment }}</h1>

            <div class="flex justify-end">
                <a href="{{ route('appointment') }}">
                 <i class="fa-solid fa-angles-right text-[30px]"></i>
                </a>
            </div>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Completed</h1>
                <i class="fa-solid fa-check-to-slot text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalCompleted }}</h1>

            <div class="flex justify-end">
                <a href="{{ route('appointments.completed') }}">
                 <i class="fa-solid fa-angles-right text-[30px]"></i>
                </a>
            </div>
        </div>
        <div class='bg-white shadow-md  px-6 py-4 rounded-md'>
            <div class='flex justify-between'>
                <h1 class='font-medium text-[18px]'>Total Earning</h1>
                <i class="fa-solid fa-peso-sign text-[50px]" style="color: #0074cb;"></i>
            </div>
            <h1 class='font-bold text-[40px]'>{{ $totalAmount }}</h1>
        </div>
    </div>

    <div class='flex gap-3 mt-3'>
        <!-- Earnings Line Chart -->
        <div class='bg-white w-full px-4 py-6 rounded-lg shadow-xl'>
            <div class='font-medium border-b py-3'>
                Total Earnings Over Time
            </div>
            <canvas id="earningsChart" style="max-width: 600px; max-height: 400px;"></canvas>
        </div>

        <div class='bg-white w-full px-4 py-6 rounded-lg shadow-xl'>
            <div class='font-medium border-b py-3'>
                Appointment Status Breakdown
            </div>
            <div class="flex justify-center" style="height: 400px;">
                <canvas id="statusChart" class="" style="max-width: 400px; max-height: 400px;"></canvas>
            </div>
        </div>
        <div class='bg-white w-full px-4 py-6 rounded-lg shadow-xl'>
            <div class='font-medium border-b py-3'>
                Patients Review
            </div>
            <div class="flex justify-center items-center h-[400px]">
                <canvas id="ratingChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <div class='bg-white w-full mt-5 px-4 rounded-lg shadow-xl'>
    <div class='font-medium border-b py-3'>
        Appointment Today
    </div>

    <div>
        @if ($appointments->isEmpty())
            <div class="py-5 text-center text-gray-600">
                No Appointments Today
            </div>
        @else
            <table class="min-w-full bg-white border mt-3">
                <thead>
                    <tr class="text-left">
                        <th class="py-3 px-4 border-b">ID</th>
                        <th class="py-3 px-4 border-b">Patient Name</th>
                        <th class="py-3 px-4 border-b">Visit Type</th>
                        <th class="py-3 px-4 border-b">Doctor</th>
                        <th class="py-3 px-4 border-b">Appointment Date</th>
                        <th class="py-3 px-4 border-b">Appointment Time</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td class="py-3 px-4 border-b">{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                            <td class="py-3 px-4 border-b">{{ $appointment->doctor }}</td>
                            <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                            <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
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
                            <td class="py-3 px-4 border-b">
                                <div class='flex gap-2'>
                                    <!-- Approve Action -->
                                    <form action="{{ route('appointments.approve', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="relative group cursor-pointer"
                                            @if($appointment->status === 'approved' || $appointment->status === 'completed') disabled @endif>
                                            <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                                                @if($appointment->status === ' approved' || $appointment->status === 'completed') cursor-not-allowed opacity-50 @endif'>
                                                <i class="fa-solid fa-thumbs-up" style="color: #3bce54;"></i>
                                            </div>
                                        </button>
                                    </form>

                                    <!-- Complete Action -->
                                    <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="relative group cursor-pointer"
                                            @if($appointment->status === 'completed') disabled @endif>
                                            <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                                                @if($appointment->status === ' completed') cursor-not-allowed opacity-50 @endif'>
                                                <i class="fa-solid fa-check-to-slot" style="color: #0074cb;"></i>
                                            </div>
                                        </button>
                                    </form>

                                    <!-- Reject Action -->
                                    <form action="{{ route('appointments.reject', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="relative group cursor-pointer"
                                            @if($appointment->status === 'rejected' || $appointment->status === 'completed') disabled @endif>
                                            <div class='bg-white py-1 px-2 border border-[#0074CB] rounded-md 
                                                @if($appointment->status === ' rejected' || $appointment->status === 'completed') cursor-not-allowed opacity-50 @endif'>
                                                <i class="fa-solid fa-thumbs-down" style="color: #d02525;"></i>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>

    </div>

    

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Earnings data and labels
        const earningsData = @json(array_values($monthlyEarnings));
        const earningsLabels = @json(array_keys($monthlyEarnings));  // Labels in 'm-d-y' format
        
        // Ensure 5 days are displayed, format as 'm-d-y'
        const currentDate = new Date();
        let fiveDays = [];
        
        for (let i = 4; i >= 0; i--) {
            const day = new Date();
            day.setDate(currentDate.getDate() - i);
            
            // Format the date as 'm-d-y' to match earningsLabels format
            const formattedDate = ('0' + (day.getMonth() + 1)).slice(-2) + '-' + 
                                  ('0' + day.getDate()).slice(-2) + '-' + 
                                  day.getFullYear().toString().slice(-2);
            fiveDays.push(formattedDate);
        }
        
        // Fill missing data points with 0 if no earnings for a day
        let earningsDataWithFiveDays = fiveDays.map(day => {
            const index = earningsLabels.indexOf(day);
            return index !== -1 ? earningsData[index] : 0;
        });

        // Create the earnings chart
        const ctxEarnings = document.getElementById('earningsChart').getContext('2d');
        const earningsChart = new Chart(ctxEarnings, {
            type: 'line',
            data: {
                labels: fiveDays,  // Display the last 5 days
                datasets: [{
                    label: 'Total Earnings (₱)',
                    data: earningsDataWithFiveDays,  // Total earnings mapped to 5 days
                    borderColor: '#0074cb',
                    backgroundColor: 'rgba(0, 116, 200, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    spanGaps: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        type: 'category',
                        labels: fiveDays,  // Ensure the x-axis shows the last 5 days
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return '₱' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Status Data
        const statusCounts = @json($statusCounts);

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Approved', 'Completed', 'Rejected'],
                datasets: [{
                    label: 'Appointment Status',
                    data: [statusCounts.pending, statusCounts.approved, statusCounts.completed, statusCounts.rejected],
                    backgroundColor: ['#FFA500', '#28a745', '#007bff', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Ensure the donut chart also scales properly
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'center', // Aligns the legend to the center
                        labels: {
                            usePointStyle: true, // Use point style for labels
                            boxWidth: 10, // Set the width of the box for the labels
                        },
                    },
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
                        '#4299e1'  // Blue for 5 Stars
                    ],
                    borderColor: [
                        '#e53e3e', // Border red
                        '#dd6b20', // Border orange
                        '#d69e2e', // Border yellow
                        '#38a169', // Border green
                        '#3182ce'  // Border blue
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

    });
</script>


@endsection