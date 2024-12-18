@extends('dashboard.layouts.main')

@section('container')
    <div class="w-full flex justify-center">
        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-end px-4 pt-4">
                <button id="dropdownButton" data-dropdown-toggle="dropdown"
                    class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                    type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 3">
                        <path
                            d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown"
                    class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton">

                        <li>
                            <a href="javascript:void(0)" onclick="convertToImage()"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cetak
                                Kartu</a>
                        </li>
                        <li>
                            <a href="/qrcode?q={{ $user->qrcode }}&download=true" target="_blank"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cetak
                                Qrcode</a>
                        </li>
                        <li>
                            <a href="#" data-modal-target="popup-modal"
                                data-modal-toggle="popup-modal"class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col items-center pb-10 ">
                <div id="card" class="p-10  flex flex-col items-center ">
                    <img src="/images/logoabsen.png" alt="" class="h-12 w-12">
                    <p class="text-xs text-gray-500">ABM's Admin </p>
                    <h5
                        class="mb-1 text-xl font-medium  dark:text-white text-blue-800  border-b-2 pb-3 w-full text-center mb-3 border-slate-900 ">
                        {{ $user->name }}</h5>
                    <span class="text-md font-semibold text-cyan-500 dark:text-gray-400 ">{{ $user->email }}</span>
                    <span class="text-sm text-cyan-500 dark:text-gray-400">{{ 'Admin' }}</span>
                    @if ($user->role)
                        <span class="text-sm text-cyan-500 dark:text-gray-400">{{ $user->role }}</span>
                    @endif
                </div>

                <div class="flex mt-4 md:mt-6">
                    <a href="/edit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection
