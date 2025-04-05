@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 " style="background: linear-gradient(to bottom, #0074C8, #151A5C);">
        <div class="w-full sm:max-w-md mt-6 px-10 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form class="space-y-4 md:space-y-6" method="post" action="{{ route('login.action') }}">
                @csrf
                <div class='my-5 flex flex-col justify-center items-center '>
                    <img src="{{ asset('images/logo.png') }}" alt="Image" class='w-[120px] '>
                    <h1 class='text-[25px] font-medium'>Login to your Account</h1>
                    <a href="" class=''>Welcome back!</a>
                </div>
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li><span class="block sm:inline">{{ $error }}</span></li>
                        @endforeach
                    </ul>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
                @endif
                <div>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-300">
                    <i class='fa-solid fa-eye-slash'></i>
                    </button>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input name="remember" id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-[#0074C8] px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-[#0074C8] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                    Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-primary-600 text-[#0074C8] hover:underline dark:text-primary-500">Sign up</a> or <a href="{{ route('forgotPassword') }}" class="font-medium text-primary-600 text-[#0074C8] hover:underline dark:text-primary-500">Forgot Password? </a>
                </p>
            </form>
        </div>
    </div>
</body>
<script>
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    togglePassword.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.innerHTML = "<i class='fa-solid fa-eye'></i>";
        } else {
            passwordInput.type = "password";
            this.innerHTML = "<i class='fa-solid fa-eye-slash'></i>";
        }
    });
</script>
</html>
@endsection