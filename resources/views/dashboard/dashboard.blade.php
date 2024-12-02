@extends('dashboard.layouts.main')

@section('container')
    @php
        $role = 'Karyawan';
        $u = auth()->user();
        if ($u->is_admin) {
            $role = 'Admin';
        }
        if ($u->is_superadmin) {
            $role = 'Super Admin';
        }

    @endphp
    <div class=" px-10 rounded-lg py-5 mb-3 glass">

        <div class="flex items-center  mt-10 w-full flex-col">
            <div class="flex flex-wrap px-10 rounded-lg pt-3 pb-2 mb-3 justify-center w-full glass">
                <h1 class="h2 font-semibold text-center text-xl p-2.5"> Selamat Datang

                    {{ $role }} di Aplikasi Presensi Karyawan PT Abdi
                    Budi
                    Mulia</h1>

            </div>
            @if (auth()->user()->is_admin || auth()->user()->is_superadmin)
                <div class="glass w-full rounded-lg my-5">
                    <h1 class="font-semibold text-4xl ms-10 mt-10">Ringkasan
                        {{ auth()->user()->divisions_id ? ': ' . auth()->user()->division->name : '' }}</h1>
                    <div class="   my-5 p-5 rounded-lg flex flex-wrap ">
                        <a href="/dashboard/employees" class="w-1/2 ">
                            <div
                                class="glass h-56 min-w-72 flex items-center p-6 rounded-lg m-5 shadow-lg bg-white/10 border-l border-red backdrop-blur-md border border-white/30">
                                <div>
                                    <svg class="w-24 h-24 mx-2 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-slate-900 text-2xl font-semibold">
                                        Total Pengguna
                                    </div>
                                    <div class="mt-2 text-4xl font-bold text-red-500">
                                        {{ $users }}
                                    </div>
                                </div>

                            </div>
                        </a>
                        <a href="" class="w-1/2">
                            <div
                                class="glass h-56 min-w-72 flex items-center p-6 rounded-lg m-5 shadow-lg bg-white/10 border-l border-red backdrop-blur-md border border-white/30">
                                <div class="">
                                    <svg class="w-24 h-24 mx-2 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="">
                                    <div class="text-slate-900 text-2xl font-semibold">
                                        Total Admin
                                    </div>
                                    <div class="mt-2 text-4xl font-bold text-red-500">
                                        {{ $admin }}
                                    </div>
                                </div>

                            </div>
                        </a>
                        <a href="" class="w-1/2">
                            <div
                                class="glass h-56 min-w-72 flex items-center p-6 rounded-lg m-5 shadow-lg bg-white/10 border-l border-red backdrop-blur-md border border-white/30">
                                <div>
                                    <svg class="w-24 h-24 mx-2 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-slate-900 text-2xl font-semibold">
                                        Total Karyawan
                                    </div>
                                    <div class="mt-2 text-4xl font-bold text-red-500">
                                        {{ $employees }}
                                    </div>
                                </div>

                            </div>
                        </a>

                        @if (!auth()->user()->divisions_id || auth()->user()->is_superadmin)
                            <a href="" class="w-1/2">
                                <div
                                    class="glass h-56 min-w-72 flex items-center p-6  rounded-lg m-5 shadow-lg bg-white/10 border-l border-red backdrop-blur-md border border-white/30">
                                    <div class="flex items-center">
                                        <svg class="w-24 h-24 mx-2.5 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <title>bag</title>
                                            <path
                                                d="M21.25 12.063v3.75c-2.969 1.094-6.656 1.719-10.625 1.719s-7.656-0.625-10.625-1.719v-3.75c0-0.688 0.563-1.25 1.25-1.25h5.156v-0.938c0-1.438 1.188-2.656 2.656-2.656h3.125c1.469 0 2.656 1.219 2.656 2.656v0.938h5.156c0.688 0 1.25 0.563 1.25 1.25zM7.969 9.875v0.938h5.313v-0.938c0-0.594-0.5-1.094-1.094-1.094h-3.125c-0.594 0-1.094 0.5-1.094 1.094zM9.063 15.594v0.625c0 0.188 0.125 0.313 0.313 0.313h2.5c0.188 0 0.313-0.125 0.313-0.313v-0.625c0-0.188-0.125-0.313-0.313-0.313h-2.5c-0.188 0-0.313 0.125-0.313 0.313zM0 23.969v-6.813c3 1.031 6.656 1.625 10.625 1.625s7.625-0.594 10.625-1.625v6.813c0 0.688-0.563 1.25-1.25 1.25h-18.75c-0.688 0-1.25-0.563-1.25-1.25zM12.188 20.75v-0.625c0-0.188-0.125-0.313-0.313-0.313h-2.5c-0.188 0-0.313 0.125-0.313 0.313v0.625c0 0.188 0.125 0.313 0.313 0.313h2.5c0.188 0 0.313-0.125 0.313-0.313z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="">

                                        <div class="text-slate-900 text-2xl font-semibold">
                                            Total Jabatan
                                        </div>
                                        <div class="mt-2 text-4xl font-bold text-red-500">

                                            {{ $subdivision }}
                                        </div>
                                    </div>

                                </div>
                            </a>
                        @endif



                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                @if (auth()->user()->divisions_id)
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">

                        <div class="flex justify-between items-start w-full">
                            <div class="flex-col items-center">
                                <div class="flex items-center mb-1">
                                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Presensi
                                        {{ auth()->user()->division->name }}</h5>

                                </div>
                                <span
                                    class="inline-flex items-center text-blue-700 dark:text-blue-600 font-medium hover:underline">
                                    Hari ini
                                </span>

                            </div>
                            <div class="flex justify-end items-center">


                            </div>
                        </div>

                        <!-- Line Chart -->
                        <div class="py-6" id="pie-chart"></div>

                        <div
                            class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                            <div class="flex justify-between items-center pt-5">


                                <a href="/dashboard/absen"
                                    class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                                    Lihat
                                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <script>
                        const getChartOptions = () => {
                            return {
                                series: [{{ $hadir }}, {{ $tidakhadir }}],
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
                                labels: ["Hadir", "Tidak Hadir"],
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
                                            return value
                                        },
                                    },
                                },
                                xaxis: {
                                    labels: {
                                        formatter: function(value) {
                                            return value
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
                @else
                    <div class="glass w-full min-h-56 rounded-lg my-5 p-5">

                        <div class=" w-full glass rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                            <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                                <dl>
                                    <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Presensi Hari
                                        Ini
                                    </dd>
                                </dl>

                            </div>

                            <div class="grid grid-cols-2 py-3">
                                <dl>
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Hadir</dt>
                                    <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">
                                        {{ $hadir }}</dd>
                                </dl>
                                <dl>
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Tidak Hadir</dt>
                                    <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500">
                                        {{ $tidakhadir }}
                                    </dd>
                                </dl>
                            </div>

                            <div id="presensi"></div>
                            <div
                                class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                                <div class="flex justify-between items-center pt-5">
                                    @if (auth()->user()->is_admin)
                                        <a href="/dashboard/absen"
                                            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                                            Lihat
                                            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>



                    <script>
                        const getSubdivisions = async () => {
                            const response = await fetch("/dashboard/subdivisions");
                            return await response.json();
                        };

                        const getAttendanceData = async (id) => {
                            const response = await fetch(`/dashboard/absen/subdivisions?s=${id}`);
                            const {
                                hadir,
                                total
                            } = await response.json();
                            return {
                                hadir,
                                total
                            };
                        };

                        const generateChartData = async (subdivisions) => {
                            const hadirData = [];
                            const tidakHadirData = [];

                            for (const s of subdivisions) {
                                const {
                                    hadir,
                                    total
                                } = await getAttendanceData(s.id);
                                hadirData.push(hadir);
                                tidakHadirData.push(total - hadir);
                            }

                            return {
                                hadirData,
                                tidakHadirData
                            };
                        };

                        document.addEventListener("DOMContentLoaded", async () => {
                            const subdivisions = await getSubdivisions();
                            const {
                                hadirData,
                                tidakHadirData
                            } = await generateChartData(subdivisions);

                            const options = {
                                series: [{
                                        name: "Hadir",
                                        color: "#31C48D",
                                        data: hadirData,
                                    },
                                    {
                                        name: "Tidak Hadir",
                                        color: "#F05252",
                                        data: tidakHadirData,
                                    },
                                ],
                                chart: {
                                    sparkline: {
                                        enabled: false
                                    },
                                    type: "bar",
                                    width: "100%",
                                    height: 1000,
                                    toolbar: {
                                        show: false
                                    },
                                },
                                fill: {
                                    opacity: 1
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: true,
                                        columnWidth: "100%",
                                        borderRadius: 6,
                                        dataLabels: {
                                            position: "top"
                                        },
                                    },
                                },
                                legend: {
                                    show: true,
                                    position: "bottom",
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                tooltip: {
                                    shared: true,
                                    intersect: false,
                                },
                                xaxis: {
                                    labels: {
                                        show: true,
                                        style: {
                                            fontFamily: "Inter, sans-serif",
                                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                                        },
                                    },
                                    categories: subdivisions.map(s => s.name),
                                    axisTicks: {
                                        show: false
                                    },
                                    axisBorder: {
                                        show: false
                                    },
                                },
                                yaxis: {
                                    labels: {
                                        show: true,
                                        style: {
                                            fontFamily: "Inter, sans-serif",
                                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                                        },
                                    },
                                },
                                grid: {
                                    show: true,
                                    strokeDashArray: 4,
                                    padding: {
                                        left: 2,
                                        right: 2,
                                        top: -20
                                    },
                                },
                            };

                            const chartContainer = document.getElementById("presensi");
                            if (chartContainer && typeof ApexCharts !== 'undefined') {
                                const chart = new ApexCharts(chartContainer, options);
                                chart.render();
                            }
                        });
                    </script>
                @endif
            @endif




        </div>
    @endsection
