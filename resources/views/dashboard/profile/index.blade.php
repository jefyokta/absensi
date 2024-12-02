@extends('dashboard.layouts.main')

@section('container')
    <div class="w-full flex justify-center">
        <div
            class="w-full max-w-sm  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
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
                        @if (auth()->user()->id == $user->id)
                            <li>
                                <a href="#" data-modal-target="popup-modal"
                                    data-modal-toggle="popup-modal"class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="flex flex-col items-center pb-10 ">
                <div id="card" class="p-10  flex flex-col items-center ">
                    <img class="w-24 h-24 mb-3  " src="/qrcode?q={{ $user->qrcode }}" alt="Bonnie image" />
                    <img src="/images/logoabsen.png" alt="" class="h-12 w-12">
                    <p class="text-xs text-gray-500">ABM's Emplooyee</p>
                    <h5
                        class="mb-1 text-xl font-medium  dark:text-white text-blue-800  border-b-2 pb-3 w-full text-center mb-3 border-slate-900 ">
                        {{ $user->name }}</h5>
                    @if (!auth()->user()->is_superadmin)
                        <span
                            class="text-lg font-semibold text-cyan-500 dark:text-gray-400 ">{{ $user->nik ?? ($user->role ?? '-') }}</span>
                    @endif
                    <span
                        class="text-md font-semibold text-cyan-500 dark:text-gray-400 ">{{ $user->division->division->name ?? ($user->role ?? '-') }}</span>
                    <span
                        class="text-sm text-cyan-500 dark:text-gray-400">{{ $user->division->name ?? 'Not In a Division' }}</span>
                    @if ($user->role)
                        <span class="text-sm text-cyan-500 dark:text-gray-400">{{ $user->role }}</span>
                    @endif
                </div>
                @if (auth()->user()->id == $user->id)
                    <div class="flex mt-4 md:mt-6">
                        <a href="/edit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>

                    </div>
                @endif
            </div>
        </div>
        <div class="bg-white flex items-center w-6/12 ms-5 p-10">

            <table class="w-full  text-xl font-semibold" cellpadding="10px">
                <tr class="p-5 text-3xl text-blue-800 my-10 border-b-2">
                    <td>Profile</td>

                </tr>
                <tr class="p-5 my-10 border-b-2">
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $user->name }}</td>
                </tr>
                @if (!auth()->user()->is_superadmin)
                    <tr class="p-5 my-10 border-b-2">
                        <td>Nik</td>
                        <td>:</td>
                        <td>{{ $user->nik }}</td>
                    </tr>
                @endif
                <tr class="p-5 my-10 border-b-2">
                    <td>Posisi</td>
                    <td>:</td>
                    <td>{{ $user->role }}</td>
                </tr>
                <tr class="p-5 my-10 border-b-2">
                    <td>Unit</td>
                    <td>:</td>
                    <td>{{ $user->division->name ?? '-' }}</td>
                </tr>

            </table>


        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function convertToImage() {
            const node = document.getElementById('card');
            html2canvas(node).then(function(canvas) {
                var dataUrl = canvas.toDataURL('image/png');
                var link = document.createElement('a');
                link.href = dataUrl;
                link.download = '{{ $user->name . '.png' }}';
                link.click();
                // fetch('', {
                //         method: 'POST',
                //         headers: {
                //             'Content-Type': 'application/json',
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                //         },
                //         body: JSON.stringify({
                //             image: dataUrl
                //         })
                //     })
                //     .then(response => response.json())
                //     .then(data => {
                //         console.log('Success:', data);
                //     })
                //     .catch((error) => {
                //         console.error('Error:', error);
                //     });
            });
        }
    </script>
@endsection
