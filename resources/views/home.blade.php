@extends('layouts.user');

@section('title', 'Home')

@section('contents')
<div>
    <div class="relative w-full h-[700px]">
        <img src="{{ asset('images/ImgClinic.jpg') }}" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Dark overlay -->
        <div class="absolute inset-0 flex flex-col gap-4 justify-center items-center w-[700px] mx-auto text-white">
            <h2 class=" text-center text-2xl md:text-3xl lg:text-5xl font-semibold">Book your Appointment, whether in-person or online</h2>
            <span class="text-center text-[13px] w-[600px] font-medium">We provide personalized, top-quality healthcare in our modern facility. From comprehensive medical care to preventive services, our expert team is here to ensure your well-being and comfort.</span>
            <a href="" class="bg-[#0074CB] py-2 px-7 font-medium rounded-full">
                <button>Set Appointment</button>
            </a>
        </div>
    </div>

</div>
@endsection