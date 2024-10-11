@extends('layouts.app')

@section('title', 'Profile Settings')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Profile Settings</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-10'>
    <div class='bg-white w-full -mt-5 rounded-lg shadow-md p-8'>
    <div>       
    <h1 class="font-bold mb-4">Profile Picture</h1>
    <div>
        <div class="flex">
            <div class="border text-center border-[#5EA7E6] text-[#5EA7E6] rounded-full h-30 w-30 flex justify-center items-center  overflow-hidden">
                <!-- Show Profile Picture if Exists, Otherwise Show Initials -->
                @if(Auth::user()->profile_picture)
                <img src="{{ asset('profile_pictures/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="h-24 w-24 object-cover rounded-full">
                @else
                    <div class='text-[28px]'>
                        {{ strtoupper(substr(explode(' ', Auth::user()->name)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Image Upload Form -->
        <form action="{{ route('profile.update_picture') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <label for="profile_picture" class="block mb-2">Change Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="border p-2 mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
        </form>
    </div>
</div>

        <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-3 gap-4 mt-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Profile Name</label>
                <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->name }}" disabled/>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->email }}" disabled/>
            </div>
            
            <div>   
                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->date_of_birth }}" />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->phone_number }}"/>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->address }}"/>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    <option value="">---choose---</option>
                    <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <div class='flex gap-4'>
                <label>
                    <input type="radio" name="status" value="active" {{ Auth::user()->status == 'active' ? 'checked' : '' }}>
                    <span>Active</span>
                </label>
                <label>
                    <input type="radio" name="status" value="inactive" {{ Auth::user()->status == 'inactive' ? 'checked' : '' }}>
                    <span>Inactive</span>
                </label>
            </div>
        </div>

            <div class="col-span-3 mt-10">
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md">Update</button>
                </div>
            </div>
        </form>

   
</div>
@endsection