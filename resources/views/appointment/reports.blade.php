@extends('layouts.app')

@section('title', 'Admin')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Reports</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>Transaction History</span>
    </div>

    <div class=''>
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Demographics Section -->
            <div class="flex-1 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold border-b pb-3">Demographics Total</h3>
                <div class="flex flex-col lg:flex-row gap-6 mt-4">
                    <!-- Gender Chart -->
                    <div class="w-full lg:w-1/3">
                        <h1>Gender</h1>
                        <canvas id="genderChart"></canvas>
                        <div class="mt-4 flex flex-col text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-4 h-4 bg-blue-500 rounded-full"></span>
                                Male: {{ $malePercentage }}%
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="w-4 h-4 bg-orange-500 rounded-full"></span>
                                Female: {{ $femalePercentage }}%
                            </div>
                        </div>
                    </div>
                    <!-- Age Chart -->
                    <div class="w-full lg:w-2/3">
                        <h1>Age</h1>
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-6 w-full lg:w-1/3">
                <!-- Services Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold border-b pb-3">Services</h3>
                    <div class="mt-4">
                        <canvas id="servicesChart"></canvas>
                    </div>
                </div>


                <!-- Total Sales Section -->
                <!-- Total Sales Section -->
<div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">
    <h3 class="text-lg font-semibold border-b pb-3">Total Sales</h3>
    <p class="text-2xl font-bold text-gray-700 pt-2">Php {{ number_format($totalSales, 2) }}</p>
</div>


            </div>
        </div>


    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gender Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $malePercentage }}, {{ $femalePercentage }}],
                backgroundColor: ['#3b82f6', '#fb923c'],
            }]
        },
        options: {
            responsive: true,
        }
    });
    // Age Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: ['0-10', '11-20', '21-30', '31-40', '41-50', '51-60', '61-70', '71-80', '81-90'],
            datasets: [{
                label: 'Age Distribution',
                data: [
                    {{ $ageRanges['0-10'] }},
                    {{ $ageRanges['11-20'] }},
                    {{ $ageRanges['21-30'] }},
                    {{ $ageRanges['31-40'] }},
                    {{ $ageRanges['41-50'] }},
                    {{ $ageRanges['51-60'] }},
                    {{ $ageRanges['61-70'] }},
                    {{ $ageRanges['71-80'] }},
                    {{ $ageRanges['81-90'] }}
                ],
                backgroundColor: '#3b82f6',
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true
                },
            },
        }
    });

    // Services Chart (Fixed code with horizontal bar type)
    const servicesCanvas = document.getElementById('servicesChart');
    if (servicesCanvas) {
        const servicesCtx = servicesCanvas.getContext('2d');
        new Chart(servicesCtx, {
            type: 'bar',
            data: {
                labels: ['Medical Consultation', 'Pediatric Consultation', 'Pediatric Ears, Nose and Throat', 'Adult Ears, Nose and Throat', 'Minor Suturing', 'Wound Dressing'],
                datasets: [{
                    label: 'Services Usage',
                    data: [
                        @json($services['Medical Consultation']),
                        @json($services['Pediatric Consultation']),
                        @json($services['Pediatric Ears, Nose and Throat']),
                        @json($services['Adult Ears, Nose and Throat']),
                        @json($services['Minor Suturing']),
                        @json($services['Wound Dressing']),
                    ],
                    backgroundColor: '#3b82f6',
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y', // Makes the bars horizontal
            }
        });
    } else {
        console.error('Services chart canvas not found');
    }
</script>

@endsection