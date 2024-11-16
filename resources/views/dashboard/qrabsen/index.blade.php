@extends('dashboard.layouts.main')

@section('container')

    @use('App\Models\Absensi')

    @php
        $currentUserAbsen = Absensi::where('user_id', auth()->user()->id)
            ->where('date', date('d/m/Y'))
            ->first();

    @endphp
    <div class="my-10 flex justify-between ">
        <h1 class="text-4xl font-semibold">Scan QrAbsen {{ $type }}</h1>

        @if (!$currentUserAbsen)

            <form action="/qrabsen" method="post">
                @csrf
                <input type="hidden" name="qrcode" value="{{ auth()->user()->qrcode }}">
                <input type="hidden" name="type" value="masuk">

                <button type="submit" class="rounded-md bg-blue-500 p-1 px-2 text-white">admin</button>
            </form>
        @else
            @if (!$currentUserAbsen->status)
            @else
                @if ($type === 'masuk' && !$currentUserAbsen->in)
                    <form action="/qrabsen" method="post">
                        @csrf
                        <input type="hidden" name="qrcode" value="{{ auth()->user()->qrcode }}">
                        <input type="hidden" name="type" value="masuk">

                        <button type="submit" class="rounded-md bg-blue-500 p-1 px-2 text-white">Saya</button>
                    </form>
                @elseif($type === 'keluar' && $currentUserAbsen->in && !$currentUserAbsen->out)
                    <form action="/qrabsen" method="post">
                        @csrf
                        <input type="hidden" name="qrcode" value="{{ auth()->user()->qrcode }}">
                        <input type="hidden" name="type" value="keluar">

                        <button type="submit" class="rounded-md bg-blue-500 p-1 px-2 text-white">Saya</button>
                    </form>
                @else
                    <button type="submit" class="rounded-md bg-green-500 p-1 px-2 text-white">Terisi</button>
                @endif
            @endif

        @endif
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

    <div class="mt-20">
        <h1 class="my-10 text-4xl font-semibold text-center">Cari manual</h1>
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
                                    @if (!$user->is_admin)
                                        <tr class="dark:bg-gray-800 rounded-lg">
                                            <td class="px-6 py-4 ">{{ $user->id }}</th>
                                            <td class="px-6 py-4 ">
                                                <img src="/qrcode?q={{ $user->qrcode }}" alt="" class="max-w-16">
                                            </td>


                                            <td class="px-6 py-4">{{ $user->nik }}</td>

                                            @if ($user->division)
                                                <td class="px-6 py-4 text-blue-500 cursor-pointer"
                                                    data-popover-target="popover-user-{{ $user->id }}">
                                                    {{ $user->name }}
                                                </td>
                                                <div data-popover id="popover-user-{{ $user->id }}" role="tooltip"
                                                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                                    <div class="p-3">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <a href="#">
                                                                <img class="w-10 h-10 qå"
                                                                    src="/qrcode?q={{ $user->qrcode }}" alt="Jese Leos">
                                                            </a>
                                                            <div>
                                                                <button type="button"
                                                                    onclick="location.href = '/dashboard/employees/{{ $user->id }}'"
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
                                                    <p class="text-danger"><i
                                                            class="fa-solid fa-triangle-exclamation"></i>-
                                                    </p>
                                                </td>
                                            @endif


                                            <td class="px-6 py-4 ">{{ $user->address }}</td>
                                            <td class="px-6 py-4 ">{{ $user->phonenumber }}</td>
                                            <td class="px-6 py-4 ">{{ $user->role ?? '-' }}</td>
                                            <td class="px-6 py-4 flex items-center">

                                                {{-- @dd($user->qrcode) --}}
                                                <button onclick="manualAbsen('{{ $user->qrcode }}')">Pilih</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>










    <form action="/qrabsen" method="post" id="form">
        @csrf
        <input type="hidden" name="qrcode" id="qrcode">
        <input type="hidden" name="type" value="{{ $type }}">
    </form>
    <script>
        const manualAbsen = (qrcode) => {
            document.getElementById("qrcode").value = qrcode;
            document.getElementById("form").submit();
        };
    </script>

    @vite(['resources/js/scanner.js'])
@endsection
