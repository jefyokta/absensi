@extends('dashboard.layouts.main')

@section('container')
    @php
    // dd(request('start'));
        use App\Services\DateID;
        $end = false;
        $start = false;
        if (request('start') && request('end')) {
            $end = explode('/', request('end'));
            if (count($end) < 3) {
                $end = false;
            }
            $start = explode('/', request('start'));
            if (count($start) < 3) {
                $start = false;
            }
        }
    @endphp
    <div
        class="flex justify-between items-center glass p-5 rounded-lg flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>

            <h1 class="font-semibold text-xl">Laporan </h1>
            <span class="text-xs">
                {{ $end && $start ? $start[0] . ' ' . DateID::getmonth($start[1]) . ' ' . $end[2] . ' sampai ' . $end[0] . ' ' . DateID::getmonth($end[1]) . ' ' . $end[2] : '' }}
            </span>
        </div>
        <div class="flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <form action="/dashboard/print" method="post">
                @csrf
                @if (!empty(request('start') && !empty(request('end'))))
                    <input type="hidden" name="start" value="{{ request('start') }}">
                    <input type="hidden" name="end" value="{{ request('end') }}">
                @endif
                <button type="submit" data-tooltip-target="tooltip-bottom" data-tooltip-placement="left"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Cetak
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </button>
                <div id="tooltip-bottom" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Max 50 data
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </form>

        </div>
    </div>

    <div class="my-10">
        <form action="/dashboard/reports">


            <div id="date-range-picker" date-rangepicker class="flex items-center " datepicker-format="dd/mm/yyyy">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input id="datepicker-range-start" name="start" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date start" autocomplete="off" datepicker-format="dd/mm/yy">
                </div>
                <span class="mx-4 text-gray-500">to</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input id="datepicker-range-end" name="end" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date end" datepicker-format="dd/mm/yyy" autocomplete="off">
                </div>

            </div>
            <div class="my-5 flex">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Apply</button>
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"><a
                        href="/dashboard/reports">Reset</a></button>
            </div>
        </form>
    </div>
    <div class="my-2">
        {{ $absensis->links() }}
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 rounded-ss-lg">
                    ID</th>
                <th scope="col" class="px-6 py-3">NAMA</th>
                <th scope="col" class="px-6 py-3">DIVISI</th>
                <th scope="col" class="px-6 py-3">TANGGAL</th>
                <th scope="col" class="px-6 py-3">MASUK</th>
                <th scope="col" class="px-6 py-3">KELUAR</th>
                <th scope="col" class="px-6 py-3 rounded-se-lg">STATUS</th>
            </tr>
        </thead>
        <tbody class="glass rounded-es-lg">
            @foreach ($absensis as $absensi)
                <tr class="dark:bg-gray-800 rounded-lg">
                    <td class="px-6 py-4 ">{{ $absensi->id }}</td>
                    <td class="px-6 py-4 ">{{ $absensi->user->name }}</td>
                    <td class="px-6 py-4 ">
                        @if ($absensi->user->division)
                            {{ $absensi->user->division->name }}
                        @else
                            <p class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> -</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 ">{{ $absensi->date }}</td>
                    <td class="px-6 py-4 ">{{ $absensi->in }}</td>
                    <td class="px-6 py-4 ">{{ $absensi->out ?? '-' }}</td>
                    <td class="px-6 py-4 ">{{ $absensi->status ? 'hadir' : 'tidak hadir' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function printReport() {
            var date = new Date();
            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];
            var currentMonth = monthNames[date.getMonth()];

            var companyName = '<div style="float: left; font-size: 20px; font-weight: bold;">Kirin ★ Performance</div>';
            var separator = '<hr style="border: 2px solid black; clear: both;" />';
            var title = '<div style="font-size: 20px; font-weight: bold; text-align: right;">Laporan ' + currentMonth +
                '</div>';

            var printContents = companyName + title + separator + document.querySelector('.table').outerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
