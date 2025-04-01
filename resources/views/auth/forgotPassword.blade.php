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
                <div class="bg-green-500 text-white p-3 mt-2 rounded-lg">
                    {{ session('success') }}
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