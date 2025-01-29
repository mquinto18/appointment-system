@extends('layouts.user')

@section('title', 'About')

@section('contents')

<div class=" max-w-[1800px] mx-auto ">
    <div class="p-5 lg:p-10">
    <div class="my-20">
        <div class="mt-[10px]">
            <h1 class="font-bold text-[20px] sm:text-2xl md:text-3xl lg:text-3xl">ABOUT</h1>
            <p class="italic text-[20px]">St. Benedict Medical Clinic</p>
        </div>

        <div class="flex flex-col sm:flex-row justify-center items-center gap-10 my-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                @foreach ($images as $image)
                <div class="">
                    <img src="{{ $image }}" alt="Image" class="w-full h-auto object-cover rounded" style="width: 1000px;">
                </div>
                @endforeach
            </div>
            <div class="flex flex-col gap-8">
                <h1 class="font-semibold text-[22px]">In St. Benedict Medical Clinic you are safe!</h1>
                <p>St. Benedict Medical Clinic & Pharmacy, your trusted healthcare provider in Brgy. Pinagbuhatan, Pasig City. Our mission is to deliver exceptional medical care and pharmacy services to our community with compassion and dedication.</p>
                <p>At St. Benedict Medical Clinic & Pharmacy, we believe in a patient-centered approach. Your health is our priority, and we are here to support you on your journey to wellness. Thank you for choosing us as your healthcare partner.</p>
                <a href="{{ route('appointment.aboutMore') }}" class="bg-[#0074CB] text-white text-center text-sm sm:text-base py-2 px-5 sm:px-7 font-medium rounded-full w-[200px]">
                    Read More
                </a>
            </div>
        </div>

        <div class="flex-cols lg:flex">
            <div class=" flex-col lg:flex-row gap-5 lg:m-10 border-l-8 rounded px-4 border-[#0074cb] my-3">
                <div>
                    <h1 class="font-semibold lg:text-[30px]">Our Mission</h1>

                    <div class="flex flex-col gap-5 lg:flex-row lg:gap-10 py-10">
                        <div class="flex flex-col gap-3">
                            <div>
                                <p class="lg:text-[20px] text-[15px]">
                                    Our mission is to provide comprehensive, accessible, and high-quality healthcare services that enhance the well-being of our patients. We are committed to treating every patient with respect and dignity while ensuring their needs are met through compassionate care, advanced medical practices, and a strong emphasis on patient education.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" flex-col lg:flex-row gap-5 lg:m-10 border-l-8 rounded px-4 border-[#0074cb] my-3">
                <div>
                    <h1 class="font-semibold lg:text-[30px]">Our Vision</h1>

                    <div class="flex flex-col gap-5 lg:flex-row lg:gap-10 py-10">
                        <div class="flex flex-col gap-3">
                            <div>
                                <p class="lg:text-[20px] text-[15px]">
                                    Our vision is to be the leading healthcare provider in Pasig City, recognized for our commitment to excellence, innovation, and community wellness. We aim to create a healthier future for our patients and the community by fostering a culture of health, promoting preventive care, and building lasting relationships based on trust.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="my-10 text-center">
                <h1 class="font-semibold lg:text-[30px]">At St. Benedict, we live by these values</h1>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8 justify-items-center">
                <div class="flex flex-col justify-center items-center gap-3">
                    <div class="bg-[#0074cb] w-20 h-20 rounded-full flex justify-center items-center">
                        <i class="fa-solid fa-hands-praying text-[30px] text-white"></i>
                    </div>
                    <p class="font-medium text-center">Compassion</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-3">
                    <div class="bg-[#0074cb] w-20 h-20 rounded-full flex justify-center items-center">
                        <i class="fa-solid fa-hands-praying text-[30px] text-white"></i>
                    </div>
                    <p class="font-medium text-center">Innovation</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-3">
                    <div class="bg-[#0074cb] w-20 h-20 rounded-full flex justify-center items-center">
                        <i class="fa-solid fa-hands-praying text-[30px] text-white"></i>
                    </div>
                    <p class="font-medium text-center">Consistency</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-3">
                    <div class="bg-[#0074cb] w-20 h-20 rounded-full flex justify-center items-center">
                        <i class="fa-solid fa-hands-praying text-[30px] text-white"></i>
                    </div>
                    <p class="font-medium text-center">Accountability</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-3">
                    <div class="bg-[#0074cb] w-20 h-20 rounded-full flex justify-center items-center">
                        <i class="fa-solid fa-hands-praying text-[30px] text-white"></i>
                    </div>
                    <p class="font-medium text-center">Accessibility</p>
                </div>
            </div>


            <div>
                <div class="my-10 text-center">
                    <p class="">St. Benedict Medical Clinic is offering comprehensive outpatient healthcare products and services. Believing that healthcare should be not just of quality, but must also be accessible, we integrated in our clinics the entire spectrum of medical services that patients need to take better care of their health</p>

                </div>
                <div class="flex justify-center items-start">
                    <a href="{{ route('appointment.user') }}" class="bg-[#0074CB] text-white text-sm sm:text-base py-2 px-5 sm:px-7 font-medium rounded-full">
                        Set Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    
<div>
@include("patient.readmoreFooter")


@endsection