    @php
        $kehadiran = App\Models\Absensi::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $ketidakhadiran = DB::select(
            "WITH hari_kerja AS (
        SELECT
            CURDATE() - INTERVAL (DAY(CURDATE()) - 1) DAY + INTERVAL seq DAY AS tanggal
        FROM (
            SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
            SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
            SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL
            SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15 UNION ALL
            SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL
            SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL
            SELECT 24 UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL
            SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30 UNION ALL SELECT 31
        ) AS seq_numbers
        WHERE MONTH(CURDATE()) = MONTH(CURDATE() - INTERVAL (DAY(CURDATE()) - 1) DAY + INTERVAL seq DAY)
          AND DATE(CURDATE() - INTERVAL (DAY(CURDATE()) - 1) DAY + INTERVAL seq DAY) <= CURDATE()
          AND WEEKDAY(CURDATE() - INTERVAL (DAY(CURDATE()) - 1) DAY + INTERVAL seq DAY) BETWEEN 0 AND 3
    ),
    kehadiran AS (
        SELECT DISTINCT DATE(`date`) AS tanggal, user_id
        FROM absensis
        WHERE user_id = ? AND status = 1
    )
    SELECT hk.tanggal
    FROM hari_kerja hk
    LEFT JOIN kehadiran k ON hk.tanggal = k.tanggal
    WHERE k.tanggal IS NULL",
            [auth()->user()->id],
        );
    @endphp
    <div class="w-full flex justify-center">

        <div class="glass p-5 max-w-max rounded-xl flex flex-col items-center">
            <h5 class="text-4xl font-bold leading-none text-gray-900 dark:text-white me-1">Presensiku
            </h5>

            <div class=" p-5 rounded-xl flex ">

                <div class="glass p-5 rounded-xl mx-5">
                    <p class="font-semibold text-xl">Presensi Bulan ini</p>
                    <p>{{ $kehadiran }}x</p>
                </div>
                <div class="glass p-5 rounded-xl mx-5">
                    <p class="font-semibold text-xl">Absensi Bulan ini</p>
                    <p>{{ count($ketidakhadiran) }}x</p>
                </div>
            </div>

            <div class="max-w-sm w-full  rounded-lg  p-4 md:p-6">

                <div class="flex justify-between items-start w-full">
                    <div class="flex-col items-center">
                        <div class="flex items-center mb-1">

                        </div>

                    </div>
                    <div class="flex justify-end items-center">

                    </div>
                </div>
                <div class="py-6" id="pie-chart"></div>

                <div class="grid grid-cols-1 items-center justify-between">
                    <div class="flex justify-between items-center pt-5">

                        <a href="/dashboard/myreports"
                            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                            Lihat
                            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                const getChartOptions = () => {
                    return {
                        series: [{{ $kehadiran }}, {{ count($ketidakhadiran) }}],
                        colors: ["#1C64F2", "#16BDCA"],
                        chart: {
                            height: 420,
                            width: "100%",
                            type: "pie",
                        },
                        stroke: {
                            colors: ["white"],
                            lineCap: "",
                        },
                        plotOptions: {
                            pie: {
                                labels: {
                                    show: true,
                                },
                                size: "100%",
                                dataLabels: {
                                    offset: -25
                                }
                            },
                        },
                        labels: ["Hadir", "Absen"],
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontFamily: "Inter, sans-serif",
                            },
                        },
                        legend: {
                            position: "bottom",
                            fontFamily: "Inter, sans-serif",
                        },
                        yaxis: {
                            labels: {
                                formatter: function(value) {
                                    return value + " hari"
                                },
                            },
                        },
                        xaxis: {
                            labels: {
                                formatter: function(value) {
                                    return value + " hari"
                                },
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                        },
                    }
                }

                if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
                    chart.render();
                }
            </script>

        </div>
    </div>
