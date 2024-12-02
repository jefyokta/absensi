@extends('dashboard.layouts.main')

@section('container')
    <div
        class="glass rounded-lg p-5 max-h-content flex justify-between items-center flex-wrap flex-md-nowrap  pt-3 pb-2 mb-3 border-bottom">
        <h1 class="font-semibold p-2 text-xl">Data Karyawan {{ $divisions->name }}</h1>
        <div>
            {{-- <div class="flex justify-between rounded-lg p-1.5 bg-blue-500  "> --}}
            <a href="/dashboard/employees/create" class="text-white text-s px-3 py-1 rounded-md  bg-blue-500">Tambah</a>
            {{-- </div> --}}
            <a href="/dashboard/sub_division/export?sd={{ $divisions->id }}"
                class="px-3 py-1 rounded-md text-white bg-green-500">Export</a>
            <a href="/dashboard/sub_division/print?sd={{ $divisions->id }}"
                class="px-3 py-1 rounded-md text-white bg-indigo-500">Cetak</a>
        </div>

    </div>
    {{-- @include('superadmin.components.employees') --}}

    <livewire:employees />
    {{--
    <div>
        <div class="max-w-md my-5 mx-auto">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <form>
                    @foreach (request()->except('search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Cari Karyawan" required />
                </form>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-ss-lg">
                                        NO</th>
                                    <th scope="col" class="px-6 py-3 ">QRCODE</th>
                                    <th scope="col" class="px-6 py-3 ">NIK</th>
                                    <th scope="col" class="px-6 py-3 ">NAMA</th>
                                    <th scope="col" class="px-6 py-3 ">UNIT</th>
                                    <th scope="col" class="px-6 py-3 ">ALAMAT</th>
                                    <th scope="col" class="px-6 py-3 ">NOMOR TELEPON</th>
                                    <th scope="col" class="px-6 py-3 ">JABATAN</th>
                                    <th scope="col" class="px-6 py-3 rounded-se-lg">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="glass rounded-es-lg">

                                @foreach ($users as $index => $user)
                                    <tr class="dark:bg-gray-800 rounded-lg">
                                        <td class="px-6 py-4 ">{{ $index + 1 }}</th>
                                        <td class="px-6 py-4 ">
                                            <img src="/qrcode?q={{ $user->qrcode }}" alt="" class="max-w-16">
                                        </td>


                                        <td class="px-6 py-4">{{ $user->nik }}</td>

                                        @if ($user->division)
                                            <td class="px-6 py-4 text-blue-500 cursor-pointer" data-popover-trigger="click"
                                                data-popover-target="popover-user-{{ $user->id }}">{{ $user->name }}
                                            </td>
                                            <td class="px-6 py-4">{{ $user->division->name }}</td>
                                        @else
                                            <td class="px-6 py-4">{{ $user->name }}</td>
                                            <td class="px-6 py-4 ">
                                            </td>
                                        @endif


                                        <td class="px-6 py-4 ">{{ $user->address }}</td>
                                        <td class="px-6 py-4 ">{{ $user->phonenumber }}</td>
                                        <td class="px-6 py-4 ">{{ $user->role ?? '-' }}</td>
                                        <td class="px-6 py-4 flex items-center">
                                            @if (!$user->is_admin)
                                                <a href="/dashboard/employees/{{ $user->id }}/edit"
                                                    class="badge bg-dark border-0"><svg
                                                        class="w-6 h-6 text-green-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                            clip-rule="evenodd" />
                                                    </svg></a>

                                                <button type="button" class="badge border-0"
                                                    data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                                    onclick="setId({{ $user->id }})"><svg
                                                        class="w-6 h-6 text-red-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                            clip-rule="evenodd" />
                                                    </svg></button>
                                            @endif
                                        </td>
                                    </tr>

                                    <div data-popover id="popover-user-{{ $user->id }}" role="tooltip"
                                        class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                        <div class="p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <a href="#">
                                                    <img class="w-10 h-10 qå" src="/qrcode?q={{ $user->qrcode }}"
                                                        alt="{{ $user->name }}">
                                                </a>
                                                <div>
                                                    <button type="button"
                                                        onclick="location.href = '/dashboard/employees/{{ $user->id }}'"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cek</button>
                                                </div>
                                            </div>
                                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                                <a href="#">{{ $user->name }}</a>
                                            </p>
                                            <p class="mb-3 text-sm font-normal">
                                                <a href="#"
                                                    class="hover:underline">{{ $user->division->division->name ?? '-' }}</a>
                                            </p>
                                            <p class="mb-4 text-sm">{{ $user->division->name ?? '' }}
                                            </p>
                                            <a href="#"
                                                class="text-blue-600 dark:text-blue-500 hover:underline">{{ $user->role ?? '-' }}</a>.

                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Modal -->
    <div id="delete-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="delete-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center ">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Hapus User Ini?</h3>
                    <div class="flex justify-center w-full">
                        <form action="/dashboard/divisions/" method="POST" class="d-inline" id="delete">
                            @method('delete')
                            @csrf

                            <button data-modal-hide="delete-modal" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="delete-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                            cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const setId = (id) => {
            const deleteForm = document.getElementById('delete');
            deleteForm.setAttribute('action', '/dashboard/employees/' + id);
        }
    </script>
@endsection
