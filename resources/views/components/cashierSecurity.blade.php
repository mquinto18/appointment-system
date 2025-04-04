@extends('layouts.cashier')

@section('title', 'Security Settings')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Security Settings</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -mt-10'>
    <div class='bg-white w-full -mt-5 rounded-lg shadow-md p-8'>
        <div class='border-b pb-5'>
            <h1 class="font-bold mb-4">Profile Information</h1>

            <form method="POST" action="{{ route('cashierSecurity.update') }}">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Profile Name</label>
                    <input type="text" name="name" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->name }}" />
                </div>

                <div class='mt-3'>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md" value="{{ Auth::user()->email }}" />
                </div>

                <div class="mt-5">
                    <button type="submit" class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>


        <div class='mt-5 border-b pb-5'>
            <form method="POST" action="{{ route('cashierchangePassword.update') }}">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <h1 class="font-bold mb-4">Change Password</h1>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md @error('current_password') border-red-500 @enderror" />
                    @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class='mt-3'>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="new_password" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md @error('new_password') border-red-500 @enderror" />
                    @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class='mt-3'>
                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="mt-1 block w-[500px] p-2 border border-gray-300 rounded-md @error('new_password_confirmation') border-red-500 @enderror" />
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

        <!-- Security PIN Section -->
        <!-- Security PIN Section -->
        <div class='mt-5 border-b pb-5'>
            <form method="POST" action="">
                @csrf
                @method('PUT')

                <h1 class="font-bold mb-4">Set Security PIN</h1>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Enter 6-Digit PIN</label>
                    <div class="relative w-[500px]">
                        <input type="password" name="security_pin" id="security_pin"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('security_pin') border-red-500 @enderror"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,6)"
                            maxlength="6" required />

                        <!-- Show/Hide Password Button -->
                        <button type="button" onclick="togglePinVisibility()"
                            class="absolute right-3 top-3 text-gray-500">
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>

                    @error('security_pin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <button type="submit" class="bg-[#0074C8] text-white font-medium px-5 py-2 rounded-md">Save PIN</button>
                </div>
            </form>
        </div>


        <div class='mt-5'>
            <form method="POST" action="{{ route('cashierAccount.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
                @csrf
                @method('DELETE')
                <h1 class="font-bold mb-4">Delete Account</h1>
                <p class='text-gray-700 w-[550px]'>Once your account is deleted, all of its resources and data will be
                    permanently deleted. Before deleting your account, please download
                    any data or information that you wish to retain.</p>
                <div class="mt-5">
                    <button type="submit" class="bg-[#EF2626] text-white font-medium px-5 py-2 rounded-md">Delete Account</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function togglePinVisibility() {
    const pinInput = document.getElementById("security_pin");
    const toggleIcon = document.getElementById("toggleIcon");

    if (pinInput.type === "password") {
        pinInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        pinInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

</script>
@endsection