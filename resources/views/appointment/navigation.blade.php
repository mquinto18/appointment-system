<div class='flex gap-2 mb-6 border-b'>
    <a href="{{ route('appointment') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('admin/appointment') || request()->is('appointments') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>All</span>
    </a>
    <a href="{{ route('appointments.pending') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('admin/appointments/pending') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Pending</span>
    </a>
    <a href="{{ route('appointments.approved') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('admin/appointments/approved') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Approved</span>
    </a>
    <a href="{{ route('appointments.completed') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('admin/appointments/completed') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Completed</span>
    </a>
    <a href="{{ route('appointments.rejected') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('admin/appointments/rejected') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Rejected</span>
    </a>
    <a href="{{ route('appointments.canceled') }}" class='cursor-pointer py-2 px-4 text-xl {{ request()->is('admin/appointments/canceled') ? 'font-medium border-b-4 border-blue-500 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Canceled</span>
    </a>
</div>
