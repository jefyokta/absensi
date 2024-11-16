@extends('dashboard.layouts.main')

@section('container')
    <div
        class="glass rounded-lg p-5 max-h-content flex justify-between items-center flex-wrap flex-md-nowrap  pt-3 pb-2 mb-3 border-bottom">
        <h1 class="font-semibold p-2 text-xl">Data Admin</h1>
        <div class="flex justify-between rounded-lg p-1.5 bg-blue-500  ">
            <a href="/super/admin/create" class="text-white text-s">Tambah Data</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <table id="selection-table"
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                            @foreach ($users as $user)
                                <tr class="dark:bg-gray-800 rounded-lg">
                                    <td class="px-6 py-4 ">{{ $user->id }}</th>
                                    <td class="px-6 py-4 ">
                                        <img src="/qrcode?q={{ $user->qrcode }}" alt="" class="max-w-16">
                                    </td>


                                    <td class="px-6 py-4">{{ $user->nik }}</td>

                                    @if ($user->division)
                                        <td class="px-6 py-4 text-blue-500 cursor-pointer"
                                            data-popover-target="popover-user-{{ $user->id }}">{{ $user->name }}</td>


                                        <div data-popover id="popover-user-{{ $user->id }}" role="tooltip"
                                            class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                            <div class="p-3">
                                                <div class="flex items-center justify-between mb-2">
                                                    <a href="#">
                                                        <img class="w-10 h-10 qå" src="/qrcode?q={{ $user->qrcode }}"
                                                            alt="Jese Leos">
                                                    </a>
                                                    <div>
                                                        <button type="button"
                                                            onclick="location.href = '/super/employee/{{ $user->id }}'"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cek</button>
                                                    </div>
                                                </div>
                                                <p
                                                    class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                                    <a href="#">{{ $user->name }}</a>
                                                </p>
                                                <p class="mb-3 text-sm font-normal">
                                                    <a href="#"
                                                        class="hover:underline">{{ $user->division->division->name ?? '-' }}</a>
                                                </p>
                                                <p class="mb-4 text-sm">{{ $user->division->name }}
                                                </p>
                                                <a href="#"
                                                    class="text-blue-600 dark:text-blue-500 hover:underline">{{ $user->role ?? '-' }}</a>.

                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>
                                        <td class="px-6 py-4">{{ $user->division->name }}</td>
                                    @else
                                        <td class="px-6 py-4">{{ $user->name }}</td>
                                        <td class="px-6 py-4 ">
                                            <p class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i>-</p>
                                        </td>
                                    @endif


                                    <td class="px-6 py-4 ">{{ $user->address }}</td>
                                    <td class="px-6 py-4 ">{{ $user->phonenumber }}</td>
                                    <td class="px-6 py-4 ">{{ $user->role ?? '-' }}</td>
                                    <td class="px-6 py-4 text-red-500">
                                        <button type="button" data-modal-target="copot-modal"
                                            data-modal-toggle="copot-modal"
                                            onclick="setId({{ $user->id }},'{{ $user->name }}')"><svg
                                                class="w-6 h-6 text-red-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg></button>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>





                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div id="copot-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="copot-modal">
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400" id="adminName">Copot Admin Ini?
                    </h3>
                    <div class="flex justify-center w-full">
                        <form action="/super/admin" method="POST" class="d-inline" id="delete">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="id" id="adminId">

                            <button data-modal-hide="copot-modal" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                iya
                            </button>
                        </form>
                        <button data-modal-hide="copot-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">tidak,
                            cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const setId = (id, name) => {
            document.getElementById('adminId').value = id
            document.getElementById('adminName').innerHTML = "copot admin `" + name + "` ?"


        }
    </script>
@endsection
