@extends('layouts.app')

@section('title', 'Profile Settings')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Security Settings</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

    <div class='mx-10 -mt-10'>
        <div class='bg-white w-full -mt-5 rounded-lg shadow-md p-8'>
            <div class='border-b pb-5'>
                <h1 class="font-bold mb-4">Profile Information</h1>
                
                <form method="POST" action="{{ route('security.update') }}">
                    @csrf  
                    @method('PUT') 

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Name</label>
                        <input type="text" name="name" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->name }}" />
                    </div>

                    <div class='mt-3'>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->email }}"/>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md">Save</button>
                    </div>
                </form>
            </div>

            <div class='mt-5'>
                <form method="POST" action="{{ route('changePassword.update') }}">
                    @csrf  
                    @method('PUT') 

                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md @error('current_password') border-red-500 @enderror"/>
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class='mt-3'>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md @error('new_password') border-red-500 @enderror"/>
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class='mt-3'>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md @error('new_password_confirmation') border-red-500 @enderror"/>
                        @error('new_password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    <div class="mt-5">
                        <button type="submit" class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection