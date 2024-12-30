@extends('layouts.cashier')

@section('title', 'Cashier')

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
        <div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">
    <h3 class="text-lg font-semibold border-b pb-3">Total Sales</h3>
    <p class="text-2xl font-bold text-gray-700 pt-2">Php {{ number_format($totalSales, 2) }}</p>
</div>
    </div>
</div>


    </div>

    <div class='bg-white w-full mt-5 px-4 rounded-lg shadow-xl'>
        <div class='font-medium  py-3'>
            <div class='border-b py-3'>
                All Trasaction History
            </div>

            <form action="{{ route('cashierReports') }}" method="GET">
                <!-- The filter fields go here -->
                <div class="flex items-end gap-10">
                    <div class="flex items-end gap-4 mt-3">
                            <div>
                                <label for="filter-year" class="font-medium text-sm">Year</label>
                                <input
                                    type="number"
                                    id="filter-year"
                                    name="filter-year"
                                    class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                                    placeholder="Enter Year (e.g., 2024)"
                                    min="2000"
                                    max="2100"
                                    value="{{ request('filter-year', now()->year) }}"
                                />
                            </div>
                            <div>
                                <label for="filter-month" class="font-medium text-sm">Month</label>
                                <select
                                    id="filter-month"
                                    name="filter-month"
                                    class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                                >
                                    <option value="">Select All</option>
                                    <option value="01" {{ request('filter-month') == '01' ? 'selected' : '' }}>January</option>
                                    <option value="02" {{ request('filter-month') == '02' ? 'selected' : '' }}>February</option>
                                    <option value="03" {{ request('filter-month') == '03' ? 'selected' : '' }}>March</option>
                                    <option value="04" {{ request('filter-month') == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ request('filter-month') == '05' ? 'selected' : '' }}>May</option>
                                    <option value="06" {{ request('filter-month') == '06' ? 'selected' : '' }}>June</option>
                                    <option value="07" {{ request('filter-month') == '07' ? 'selected' : '' }}>July</option>
                                    <option value="08" {{ request('filter-month') == '08' ? 'selected' : '' }}>August</option>
                                    <option value="09" {{ request('filter-month') == '09' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ request('filter-month') == '10' ? 'selected' : '' }}>October</option>
                                    <option value="11" {{ request('filter-month') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ request('filter-month') == '12' ? 'selected' : '' }}>December</option>
                                </select>
                            </div>
                            <div class="flex items-end gap-4">
                        <div>
                            <label for="visitType" class="font-medium text-sm">Visit Type</label>
                            <select
                                class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                                id="visitType"
                                name="visit_type" 
                            >
                                <option value="">Select All</option>
                                <option value="Medical Consultation" {{ request('visit_type') == 'Medical Consultation' ? 'selected' : '' }}>Medical Consultation</option>
                                <option value="Pediatric Consultation" {{ request('visit_type') == 'Pediatric Consultation' ? 'selected' : '' }}>Pediatric Consultation</option>
                                <option value="Pediatric Ears, Nose and Throat" {{ request('visit_type') == 'Pediatric Ears, Nose and Throat' ? 'selected' : '' }}>Pediatric Ears, Nose and Throat</option>
                                <option value="Adult Ears, Nose and Throat" {{ request('visit_type') == 'Adult Ears, Nose and Throat' ? 'selected' : '' }}>Adult Ears, Nose and Throat</option>
                                <option value="Minor Suturing" {{ request('visit_type') == 'Minor Suturing' ? 'selected' : '' }}>Minor Suturing</option>
                                <option value="Wound Dressing" {{ request('visit_type') == 'Wound Dressing' ? 'selected' : '' }}>Wound Dressing</option>
                            </select>
                        </div>

                    </div>
                        <div>
                            <button
                                type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                            >
                                Apply
                            </button>
                        </div>
                    </div>

                </div>
            </form>


        <div>
        <table class="min-w-full bg-white border mt-3">
            <thead>
                <tr class="text-left">
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Patient Name</th>
                    <th class="py-3 px-4 border-b">Gender</th>
                    <th class="py-3 px-4 border-b">Appointment Date</th>
                    <th class="py-3 px-4 border-b">Visit Type</th>
                    <th class="py-3 px-4 border-b">Amount</th>
                    <th class="py-3 px-4 border-b">Discount</th>
                    <th class="py-3 px-4 border-b">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                    <td class="py-3 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                        <td class="py-3 px-4 border-b">{{ ucfirst($appointment->gender) }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->appointment_date }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->visit_type }}</td>
                        <td class="py-3 px-4 border-b">₱ 
                            @php
                                $amount = json_decode($appointment->amount, true);
                                $totalAmount = is_array($amount) ? array_sum($amount) : 0;
                            @endphp
                            {{ number_format($totalAmount, 2) }}
                        </td>
                        <td class="py-3 px-4 border-b">{{ $appointment->discount ?? 'N/A' }}%</td>
                        <td class="py-3 px-4 border-b">₱
                            @php
                                $discount = $appointment->discount ?? 0;
                                $discountAmount = ($totalAmount * $discount) / 100;
                                $finalAmount = $totalAmount - $discountAmount;
                            @endphp
                            {{ number_format($finalAmount, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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