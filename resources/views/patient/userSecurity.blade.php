@extends('layouts.user')

@section('title', 'Security Settings')

@section('contents')
    <div class='mx-4 mt-10 md:mx-10'>
        <div class='bg-white w-full rounded-lg shadow-md p-6 md:p-8'>
            <!-- Profile Information -->
            <div class='border-b pb-5'>
                <h1 class="font-bold mb-4 text-lg">Profile Information</h1>
                <form method="POST" action="{{ route('userSecurity.update') }}">
                    @csrf  
                    @method('PUT') 

                    <!-- Profile Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Name</label>
                        <input type="text" name="name" 
                            class="mt-1 block w-full max-w-md p-2 border border-gray-300 rounded-md" 
                            value="{{ Auth::user()->name }}" />
                    </div>

                    <!-- Email -->
                    <div class='mt-3'>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" 
                            class="mt-1 block w-full max-w-md p-2 border border-gray-300 rounded-md" 
                            value="{{ Auth::user()->email }}" />
                    </div>

                    <!-- Save Button -->
                    <div class="mt-5">
                        <button type="submit" 
                            class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class='mt-5 border-b pb-5'>
                <form method="POST" action="{{ route('userchangePassword.update') }}">
                    @csrf  
                    @method('PUT') 

                    <h1 class="font-bold mb-4 text-lg">Change Password</h1>

                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" 
                            class="mt-1 block w-full max-w-md p-2 border border-gray-300 rounded-md @error('current_password') border-red-500 @enderror" />
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class='mt-3'>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" 
                            class="mt-1 block w-full max-w-md p-2 border border-gray-300 rounded-md @error('new_password') border-red-500 @enderror" />
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class='mt-3'>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" 
                            class="mt-1 block w-full max-w-md p-2 border border-gray-300 rounded-md @error('new_password_confirmation') border-red-500 @enderror" />
                        @error('new_password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    <div class="mt-5">
                        <button type="submit" 
                            class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class='mt-5'>
                <form method="POST" action="{{ route('userAccount.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
                    @csrf  
                    @method('DELETE') 
                    <h1 class="font-bold mb-4 text-lg">Delete Account</h1>
                    <p class='text-gray-700 max-w-md'>
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    <div class="mt-5">
                        <button type="submit" 
                            class="bg-[#EF2626] text-white font-medium px-5 py-2 rounded-md hover:bg-red-700">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
