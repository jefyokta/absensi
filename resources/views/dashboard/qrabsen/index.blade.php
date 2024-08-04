@extends('dashboard.layouts.main')

@section('container')
    <div class="my-10">
        <h1 class="text-4xl font-semibold">Scan QrAbsen {{ $type }}</h1>
    </div>
    <div class="flex justify-center">

        <div id="reader" class="rounded-xl overflow-hidden w-96 h-96 mx-2"></div>


        @if (!empty($user))

                <div
                    class="w-full mx-2 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-center ">
                    <div class="flex flex-col items-center pb-10">
                        <img class="w-24 h-24 mb-3  shadow-lg" src="/qrcode?q={{ $user->qrcode }}" alt="Bonnie image" />
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">#{{ $user->id }}</h5>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $user->name }}</h5>
                        <span
                            class="text-md font-semibold text-cyan-500 dark:text-gray-400">{{ $user->division->name ?? '' }}</span>
                        <span class="text-sm text-cyan-500 dark:text-gray-400">{{ 'Not In a Division' }}</span>
                        @if (!empty($success))
                        <span class="text-sm text-green-500 dark:text-gray-400">{{ $success }}</span>
                        @endif
                        @if (!empty($error))
                        <span class="text-sm text-red-500 dark:text-gray-400">{{ $error }}</span>
                        @endif
                    </div>
                </div>
        @endif


    </div>










    <form action="/qrabsen" method="post" id="form">
        @csrf
        <input type="hidden" name="qrcode" id="qrcode">
        <input type="hidden" name="type" value="{{ $type }}">
    </form>


    @vite(['resources/js/scanner.js'])
@endsection
