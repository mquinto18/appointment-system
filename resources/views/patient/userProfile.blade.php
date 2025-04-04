@extends('layouts.user')

@section('title', 'Profile Settings')

@section('contents')

<div class="mx-4 sm:mx-10 mt-10">
    <div class="bg-white w-full rounded-lg shadow-md p-6 sm:p-8">
        <div>
            <h1 class="font-bold mb-4 text-lg sm:text-xl">Profile Picture</h1>
            <div class="flex flex-col items-center sm:flex-row sm:items-start sm:gap-4">
                <div class="flex">
                    <div class="border text-center border-[#5EA7E6] text-[#5EA7E6] rounded-full h-30 w-30 flex justify-center items-center overflow-hidden">
                        <!-- Show Profile Picture if Exists, Otherwise Show Initials -->
                        @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="h-24 w-24 object-cover rounded-full">
                        @else
                        <div class='text-[28px]'>
                            {{ strtoupper(substr(explode(' ', Auth::user()->name)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Image Upload Form -->
                <form action="{{ route('profile.updateuser_picture') }}" method="POST" enctype="multipart/form-data" class="mt-4 sm:mt-0">
                    @csrf
                    <label for="profile_picture" class="block mb-2 text-sm">Change Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="border p-2 mb-4 w-full">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Upload</button>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('userProfile.update') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Profile Name</label>
                <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->name }}" disabled />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->email }}" disabled />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->date_of_birth }}" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->phone_number }}" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->address }}" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    <option value="">---choose---</option>
                    <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-3 mt-5">
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection