@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div class='max-w-7xl mx-auto mt-10'>
    <div class="bg-white rounded-md shadow-lg">
        <div class="py-5 px-5 md:px-10">
            <h1 class="font-medium text-2xl border-b pb-3">Booked Appointments</h1>

            <div class="flex flex-wrap justify-center items-center gap-4 md:gap-10 my-7">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        P
                    </div>
                    <span>Pending</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        A
                    </div>
                    <span>Approved</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        C
                    </div>
                    <span>Completed</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        R
                    </div>
                    <span>Rejected</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-red-400 text-white w-6 h-6 rounded-full flex items-center justify-center">
                        CL
                    </div>
                    <span>Cancelled</span>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                <div class="w-full max-w-md mx-auto shadow-md">
                    <div class="flex justify-between bg-[#F2F2F2] px-5 py-7">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-user text-[35px]" style="color: #0074cb;"></i>
                            <span class="text-[18px] font-bold">Jan Matthew Quinto</span>
                        </div>
                        <div class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center">
                            P 
                        </div>
                    </div>

                    <!-- Date, Time, Consultation, and Doctor Information -->
                    <div class="flex flex-col px-5 my-4">
                        <!-- First Row: Date and Consultation Type -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2 relative">
                                    <span class="w-3 h-3 border-2 border-[#9747FF] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">November 17, 2024</span>
                                    <span class="absolute w-px h-7 border-l border-gray-300 border-dashed left-[6px] top-4"></span>

                                </div>
                                <div class="flex items-center gap-2 relative">
                                    <span class="w-3 h-3 border-2 border-[#07CC62] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">3:00 PM</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 relative">
                                <div class="flex items-center gap-2 ">
                                    <span class="w-3 h-3 border-2 border-[#0074C8] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">Adult Consultation</span>
                                    <span class="absolute w-px h-7 border-l border-gray-300 border-dashed left-[6px] top-4"></span>

                                </div>
                                
                                <div class="flex items-center gap-2 relative">
                                    <span class="w-3 h-3 border-2 border-[#FD9D2D] rounded-full inline-block relative z-10"></span>
                                    <span class="text-gray-700 font-normal">Dr. Kwakkwakks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <a href="{{ route('home') }}" class="w-full h-12 bg-[#F2F2F2] border text-black font-semibold flex items-center justify-center hover:text-white hover:bg-gray-600 transition duration-200">Cancel</a>

                        <button type="submit" class="w-full h-12 bg-[#F2F2F2] cursor-pointer border text-black font-semibold hover:bg-blue-600 hover:text-white transition duration-200">Reschedule</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection