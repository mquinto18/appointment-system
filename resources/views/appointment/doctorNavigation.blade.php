<div class='flex gap-2 mb-6 border-b'>
    <a href="{{ route('doctorAppointment') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('doctor/appointment') || request()->is('doctor/appointments') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>All</span>
    </a>
    <a href="{{ route('todayAppointment') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('doctor/appointment/today') || request()->is('doctor/appointment/today') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Today</span>
    </a>
   
   
    
</div>
