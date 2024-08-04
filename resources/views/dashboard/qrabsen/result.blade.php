@extends('dashboard.layouts.main')


@section('container')
    <div class="w-full flex justify-center">
        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col items-center pb-10">
                <img class="w-24 h-24 mb-3  shadow-lg" src="/qrcode?q={{ $user->qrcode }}" alt="Bonnie image" />
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">#{{ $user->id }}</h5>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $user->name }}</h5>
                <span class="text-md font-semibold text-cyan-500 dark:text-gray-400">{{ $user->division->name }}</span>
                <span
                    class="text-sm text-cyan-500 dark:text-gray-400">{{ $user->division->name ?? 'Not In a Division' }}</span>
            </div>
        </div>
    </div>
@endsection





