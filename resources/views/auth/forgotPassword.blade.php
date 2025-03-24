<!DOCTYPE html>
<html lang="en">

<head>
    @notifyCss
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Forgot Password</title>
</head>

<body>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: linear-gradient(to bottom, #0074C8, #151A5C);">
        <div class="w-full sm:max-w-md mt-6 px-10 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <!-- Forgot Password Section -->
            <div class="">
                <h2 class="text-lg font-semibold text-gray-700 text-center">Forgot Password?</h2>
                <p class="text-sm text-gray-500 text-center">Enter your email to reset your password.</p>

                @if(session('success'))
                <div x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300 transform opacity-0 scale-90"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300 transform opacity-100 scale-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg flex items-center space-x-2"
                    x-init="setTimeout(() => show = false, 3000)">

                    <!-- Check Icon -->
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>

                    <span class="font-medium">{{ session('success') }}</span>

                    <!-- Close Button -->
                    <button @click="show = false" class="ml-auto text-white hover:text-gray-200 focus:outline-none">
                        &times;
                    </button>
                </div>
                @endif


                <form method="post" action="{{ route('password.email') }}" class="mt-4 space-y-4">
                    @csrf
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter your email" required>
                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg text-sm font-semibold hover:bg-red-600">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>