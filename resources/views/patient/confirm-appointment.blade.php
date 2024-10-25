@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg p-10">
        <h1 class="font-medium text-2xl border-b pb-3">Book Appointment</h1>

        @include('patient.navigation')

        <form id="appointmentForm" action="" method="POST"> <!-- Set the form action to your route -->
            @csrf <!-- Include CSRF token for security -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name and Last Name -->
               

                
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full h-12 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">Submit</button>
            </div>
        </form>

    </div>
</div>

@endsection
