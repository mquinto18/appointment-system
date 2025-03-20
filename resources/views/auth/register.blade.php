@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Register</title>
    <style>
        /* Modal styles */
        #loading-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0.3s, opacity 0.3s;
        }
        #loading-modal.active {
            visibility: visible;
            opacity: 1;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #0074C8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">

    <!-- Loading Modal -->
    <div id="loading-modal">
        <div class="loading-spinner"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 " style="background: linear-gradient(to bottom, #0074C8, #151A5C);">
        <div class="w-full sm:max-w-md mt-6 px-10 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form action="{{route('register.save')}}" method="POST" class="space-y-4 md:space-y-6" onsubmit="showLoadingModal()">
                @csrf
                <div class='my-5 flex flex-col justify-center items-center '>
                    <img src="{{ asset('images/logo.png') }}" alt="Image" class='w-[120px] '>
                    <h1 class='text-[25px] font-medium'>Create your account</h1>
                    <a href="" class=''>Join us and get started!</a>
                </div>

                <div>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name" required="">
                    @error('name')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    @error('email')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    @error('password')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    @error('password_confirmation')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="flex justify-center w-full bg-[#0074C8] text-white p-2 rounded-md">
                        Register
                    </button>
                </div>
                <div class='flex gap-2 justify-center text-sm mt-3'>
                    <p>Already have an account?</p>
                    <a href="{{ route('login') }}" class='font-medium text-primary-600 text-[#0074C8] hover:underline dark:text-primary-500'>Login Now</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showLoadingModal() {
            const modal = document.getElementById('loading-modal');
            modal.classList.add('active');
        }
        window.addEventListener('load', () => {
            const modal = document.getElementById('loading-modal');
            modal.classList.remove('active');
        });
    </script>
</body>
</html>
@endsection