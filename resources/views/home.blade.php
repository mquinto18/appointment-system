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
                            <p class="lg:text-[20px] text-[15px]">
                                Comprehensive Healthcare Services for Every Stage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <i class="fa-solid fa-heart-pulse text-[35px]" style="color: #0074cb;"></i>
                        <div>
                            <p class="lg:text-[20px] text-[15px]">
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
                            <p class="lg:text-[20px] text-[15px]">
                                Comprehensive Healthcare Services for Every Stage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <i class="fa-solid fa-heart-pulse text-[35px]" style="color: #0074cb;"></i>
                        <div>
                            <p class="lg:text-[20px] text-[15px]">
                                Comprehensive Healthcare Services for Every Comprehensive Healthcare Services for Every Stage of LifeStage of LifeServices for Every Stage of LifeStage of LifeServices for Every Stage of LifeStage of Life
                            </p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="my-20">
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
                        <a href="{{ route('appointment.aboutMore') }}" class="bg-[#0074CB] text-white text-center text-sm sm:text-base py-2 px-5 sm:px-7 font-medium rounded-full w-[200px]">
                            Read More
                        </a>
                    </div>
                </div>
            </div>


            <div class="my-20">
                <div class="mt-[30px] text-center">
                    <h1 class="font-bold text-[20px] sm:text-2xl md:text-3xl lg:text-3xl">Our Medical Services</h1>
                    <p class="italic text-[20px]">Great doctor if you need your family member to get effective immediate <br> assistance, emergency treatment or a simple consultation.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 text-center gap-5 my-10">
                    <div class="bg-blue-100 p-10 text-center flex flex-col items-center shadow-md">
                        <div class="my-2 w-16 h-16 rounded-full border-2 border-blue-500 flex justify-center items-center">
                            <i class="fa-solid fa-hand-holding-medical text-[30px] p-3" style="color: #0074cb;"></i>
                        </div>
                        <p>Medical Consultation (Adult)</p>
                    </div>
                    <div class="bg-blue-100 p-10 text-center flex flex-col items-center shadow-md">
                        <div class="my-2 w-16 h-16 rounded-full border-2 border-blue-500 flex justify-center items-center">
                            <i class="fa-solid fa-baby text-[35px] p-3" style="color: #0074cb;"></i>
                        </div>
                        <p>Pediatric Consultation</p>
                    </div>
                    <div class="bg-blue-100 p-10 text-center flex flex-col items-center shadow-md">
                        <div class="my-2 w-16 h-16 rounded-full border-2 border-blue-500 flex justify-center items-center">
                            <i class="fa-solid fa-stethoscope text-[35px] p-3" style="color: #0074cb;"></i>
                        </div>
                        <p>Pediatric Ears, Nose, and Throat</p>
                    </div>
                    <div class="bg-blue-100 p-10 text-center flex flex-col items-center shadow-md">
                        <div class="my-2 w-16 h-16 rounded-full border-2 border-blue-500 flex justify-center items-center">
                            <i class="fa-solid fa-stethoscope text-[35px] p-3" style="color: #0074cb;"></i>
                        </div>
                        <p>Adult Ears, Nose, and Throat</p>
                    </div>
                    <div class="bg-blue-100 p-10 text-center flex flex-col items-center shadow-md">
                        <div class="my-2 w-16 h-16 rounded-full border-2 border-blue-500 flex justify-center items-center">
                            <i class="fa-solid fa-heart-pulse text-[35px] p-3" style="color: #0074cb;"></i>
                        </div>
                        <p>Minor Suturing</p>
                    </div>
                    <div class="bg-blue-100 p-10 text-center flex flex-col items-center shadow-md">
                        <div class="my-2 w-16 h-16 rounded-full border-2 border-blue-500 flex justify-center items-center">
                            <i class="fa-solid fa-bandage text-[35px] p-3" style="color: #0074cb;"></i>
                        </div>
                        <p>Wound Dressing</p>
                    </div>

                </div>
            </div>
        </div>
        <div class="bg-blue-700 h-auto lg:h-90 my-10">
            <div class="p-5 lg:p-10 max-w-[1800px] mx-auto">
                <div>
                    <div class="flex flex-col md:flex-row gap-10 justify-between items-center">
                        <!-- Card 1 -->
                        <div class="w-full md:w-96 text-center text-white border-2 border-white py-8 px-10 rounded-lg">
                            <p class="font-medium text-[20px] mb-4">Streamlining <br> Clinic Operations</p>
                            <p>Discover how our comprehensive solutions can optimize your clinic's daily operations, reduce administrative burdens, and allow healthcare professionals to focus on what truly matters—providing exceptional patient care.</p>
                        </div>
                        <!-- Card 2 -->
                        <div class="w-full md:w-96 text-center text-white border-2 border-white py-8 px-10 rounded-lg">
                            <p class="font-medium text-[20px] mb-4">Streamlining <br> Clinic Operations</p>
                            <p>Discover how our comprehensive solutions can optimize your clinic's daily operations, reduce administrative burdens, and allow healthcare professionals to focus on what truly matters—providing exceptional patient care.</p>
                        </div>
                        <!-- Card 3 -->
                        <div class="w-full md:w-96 text-center text-white border-2 border-white py-8 px-10 rounded-lg">
                            <p class="font-medium text-[20px] mb-4">Streamlining <br> Clinic Operations</p>
                            <p>Discover how our comprehensive solutions can optimize your clinic's daily operations, reduce administrative burdens, and allow healthcare professionals to focus on what truly matters—providing exceptional patient care.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-5 lg:p-10 max-w-[1800px] mx-auto">
            <div class="mt-[30px]">
                <h1 class="font-bold text-[20px] sm:text-2xl md:text-3xl lg:text-3xl">Location</h1>
            </div>

            <div id="map" class="my-10" style="height: 400px; width: 100%;"></div>

            <div class="my-20">
                <h1 class="font-bold text-[20px] text-center sm:text-2xl md:text-3xl lg:text-3xl">We'd love to talk to you</h1>
            </div>

            <div class="lg:flex lg:flex-row justify-center lg:gap-40 items-center my-20 flex flex-col gap-10">
                <div class="bg-white p-5 rounded-[20px] w-[350px] shadow-md">
                    <div class="">
                        <h1 class="font-semibold text-[22px]">Contact Us</h1>

                        <div class="my-5">
                            <form action="{{ route('appointment.contactSend') }}" method="POST">
                                <!-- Add CSRF token for Laravel -->
                                @csrf
                                <div class="my-4">
                                    <input
                                        type="text"
                                        name="full_name"
                                        placeholder="Full Name"
                                        id="full_name"
                                        class="mt-1 block w-full bg-gray-100 rounded-md border border-gray-300 py-2 px-4"
                                        required />
                                </div>
                                <div class="my-4">
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        placeholder="Email Address"
                                        class="mt-1 block w-full bg-gray-100 rounded-md border border-gray-300 py-2 px-4"
                                        required />
                                </div>
                                <div class="my-4">
                                    <textarea
                                        placeholder="Message"
                                        class="form-control block w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        id="message"
                                        name="message"
                                        required></textarea>
                                </div>

                                <button
                                    type="submit"
                                    class="bg-[#0074C8] w-full text-white p-3 rounded-md">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0074C8] text-white rounded-[30px] w-[270px]">
                    <div class="px-10 py-20 border-b border-gray-200">
                        <h1 class="font-bold text-[50px] leading-[60px]  border-gray-200">Thank <br>You.</h1>
                    </div>
                    <div class="px-10 py-5">
                        <p class="text-[20px]">Always keep in <br> touch</p>
                    </div>
                </div>
            </div>
        </div>

        @include("patient.readmoreFooter")

    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        slidesPerView: 1,
        spaceBetween: 10,
    });

    const map = L.map('map').setView([14.5478319634832, 121.10441019387086], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    // Add a marker
    L.marker([14.5478319634832, 121.10441019387086]).addTo(map)
        .bindPopup('St. Benedict Medical Clinic & Pharmacy')
        .openPopup();
</script>
@endsection