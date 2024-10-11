<div class='flex gap-2 mb-6 border-b'>
    <a href="{{ route('appointment') }}" class='font-medium cursor-pointer py-2 px-4 text-xl {{ Request::is('appointments/all') || Request::is('appointments') ? 'border-b-4 border-b-blue-700 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>All</span>
    </a>
    <a href="{{ route('appointments.pending') }}" class='cursor-pointer py-2 px-4 text-xl {{ Request::is('appointments/pending') ? 'border-b-4 border-b-blue-700 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Pending</span>
    </a>
    <a href="{{ route('appointments.approved') }}" class='cursor-pointer py-2 px-4 text-xl {{ Request::is('appointments/approved') ? 'border-b-4 border-b-blue-700 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Approved</span>
    </a>
    <a href="{{ route('appointments.completed') }}" class='cursor-pointer py-2 px-4 text-xl {{ Request::is('appointments/completed') ? 'border-b-4 border-b-blue-700 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Completed</span>
    </a>
    <a href="{{ route('appointments.rejected') }}" class='cursor-pointer py-2 px-4 text-xl {{ Request::is('appointments/rejected') ? 'border-b-4 border-b-blue-700 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Rejected</span>
    </a>
    <a href="{{ route('appointments.canceled') }}" class='cursor-pointer py-2 px-4 text-xl {{ Request::is('appointments/canceled') ? 'border-b-4 border-b-blue-700 text-blue-700' : 'border-b-4 border-b-transparent hover:border-b-blue-700' }}'>
        <span>Canceled</span>
    </a>
</div>
