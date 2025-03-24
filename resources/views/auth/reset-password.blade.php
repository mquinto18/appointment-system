<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Reset Password</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: linear-gradient(to bottom, #0074C8, #151A5C);">
        <div class="w-full sm:max-w-md mt-6 px-10 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
           
            <!-- Reset Password Section -->
            <div>
                <h2 class="text-lg font-semibold text-gray-700 text-center">Reset Password</h2>
                <p class="text-sm text-gray-500 text-center">Enter a new password for your account.</p>


                <form method="post" action="{{ route('password.update') }}" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    <input type="hidden" name="email" value="{{ request()->query('email') }}">

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="password" required 
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
