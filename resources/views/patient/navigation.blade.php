<div class='flex flex-col sm:flex-row gap-2 mb-6 py-4'>
    <!-- Step 1 -->
    <a href="{{ url('dashboard/appointment') }}" class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg {{ request()->is('dashboard/appointment') || request()->is('appointments') ? 'font-medium border-b-2 border-blue-500 text-medium' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <div class="flex items-center justify-center h-5 w-5 border border-gray-500 rounded-full {{ request()->is('dashboard/appointment') || request()->is('appointments') ? 'font-medium bg-[#0074C8] border-blue-500 text-white' : 'border-b-1 border-b-transparent hover:border-b-blue-700' }}">
            <span class=" text-[13px]">1</span>
        </div>
        <span>Select Date, Time & Doctor</span>
    </a>

    <!-- Step 2 -->
    <a href="{{ url('dashboard/appointment/patientDetails') }}" class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg {{ request()->is('dashboard/appointment/patientDetails') || request()->is('appointment/patientDetails') ? 'font-medium border-b-2 border-blue-500 text-medium' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <div class="flex items-center justify-center h-5 w-5 border border-gray-500 rounded-full {{ request()->is('dashboard/appointment/patientDetails') || request()->is('appointment/patientDetails') ? 'font-medium bg-[#0074C8] border-blue-500 text-white' : 'border-b-1 border-b-transparent hover:border-b-blue-700' }}">
            <span class="text-[13px]">2</span>
        </div>
        <span>Patient Details</span>
    </a>

    <!-- Step 3 -->
    <a href="{{ url('dashboard/appointment/confirmDetails') }}" class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg {{ request()->is('dashboard/appointment/confirmDetails') || request()->is('appointment/confirmDetails') ? 'font-medium border-b-2 border-blue-500 text-medium' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <div class="flex items-center justify-center h-5 w-5 border border-gray-500 rounded-full {{ request()->is('dashboard/appointment/confirmDetails') || request()->is('appointment/confirmDetails') ? 'font-medium bg-[#0074C8] border-blue-500 text-white' : 'border-b-1 border-b-transparent hover:border-b-blue-700' }}">
            <span class="text-[13px]">3</span>
        </div>
        <span>Confirm Your Appointment</span>
    </a>
</div>
