@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div>
    <div class="relative w-full h-[500px] sm:h-[600px] md:h-[700px]">
        <img src="{{ asset('images/ImgClinic.jpg') }}" alt="Clinic Image" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Dark overlay -->
        <div class="absolute inset-0 flex flex-col gap-4 justify-center items-center px-4 sm:px-8 lg:px-0 text-white">
            <h2 class="text-center text-2xl sm:text-2xl md:text-3xl lg:text-5xl font-semibold leading-tight">
                Book your Appointment,<br /> whether in-person or online
            </h2>
            <span class="text-center text-[12px] sm:text-base md:text-lg max-w-[90%] sm:max-w-[600px] font-medium">
                We provide personalized, top-quality healthcare in our modern facility. From comprehensive medical care to preventive services, our expert team is here to ensure your well-being and comfort.
            </span>
            <a href="{{ route('appointment.user') }}" class="bg-[#0074CB] text-sm sm:text-base py-2 px-5 sm:px-7 font-medium rounded-full">
                Set Appointment
            </a>
        </div>

        <div class="p-5 lg:p-10 max-w-[1800px] mx-auto ">
            <div class="mb-[30px]">
                <h1 class="font-bold text-[20px] sm:text-2xl md:text-3xl lg:text-3xl">QUALITY HEALTHCARE</h1>
                <p class="italic text-[20px]">Services</p>
            </div>

            <div class=" flex-col lg:flex-row gap-5 lg:m-10 border-l-8 rounded px-4 border-[#0074cb] my-3">
                <h1 class="font-semibold text-[25px]">Patients</h1>

                <div class="flex flex-col gap-5 lg:flex-row lg:gap-10 py-10">
                    <div class="flex flex-col gap-3">
                        <i class="fa-solid fa-heart-pulse text-[35px]" style="color: #0074cb;"></i>
                        <div>
                            <p class="text-[15px]">
                                Comprehensive Healthcare Services for Every Stage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <i class="fa-solid fa-heart-pulse text-[35px]" style="color: #0074cb;"></i>
                        <div>
                            <p class="text-[15px]">
                                Comprehensive Healthcare Services for Every Comprehensive Healthcare Services for Every Stage of LifeStage of LifeServices for Every Stage of LifeStage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class=" flex-col lg:flex-row gap-5 lg:m-10 border-l-8 rounded px-4 border-[#0074cb]    ">
                <h1 class="font-semibold text-[25px]">Clinic</h1>
                <div class="flex flex-col gap-5 lg:flex-row lg:gap-10 py-10">
                    <div class="flex flex-col gap-3">
                        <i class="fa-solid fa-heart-pulse text-[35px]" style="color: #0074cb;"></i>
                        <div>
                            <p class="text-[15px]">
                                Comprehensive Healthcare Services for Every Stage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <i class="fa-solid fa-heart-pulse text-[35px]" style="color: #0074cb;"></i>
                        <div>
                            <p class="text-[15px]">
                                Comprehensive Healthcare Services for Every Comprehensive Healthcare Services for Every Stage of LifeStage of LifeServices for Every Stage of LifeStage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                </div>
            </div>



            <div>
                <div class="mt-[30px]">
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
                        <a href="{{ route('appointment.user') }}" class="bg-[#0074CB] text-white text-center text-sm sm:text-base py-2 px-5 sm:px-7 font-medium rounded-full w-[200px]">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection