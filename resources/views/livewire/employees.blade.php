<div>
    <div class="max-w-md my-5 mx-auto">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input wire:model.live="search" type="search" id="default-search"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Cari Karyawan" required />

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
                            @foreach ($users as $i => $user)
                                <tr class="dark:bg-gray-800 rounded-lg">
                                    <td class="px-6 py-4 ">{{ $users->firstItem() + $i }}</th>
                                    <td class="px-6 py-4 ">
                                        <img src="/qrcode?q={{ $user->qrcode }}" alt="" class="max-w-16">
                                    </td>


                                    <td class="px-6 py-4">{{ $user->nik }}</td>

                                    @if ($user->division)
                                        <td class="px-6 py-4 text-blue-500 cursor-pointer" 
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
                    <div class="my-5">

                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
