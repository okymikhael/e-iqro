@extends('pages.app')

@section('content')

<div class="px-4 py-3 m-8 bg-white rounded-lg shadow-md dark:bg-gray-800 bg-opacity-90">
    <div class="flex items-center justify-between mx-6">
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
            {{$siswa->nama_lengkap}}
        </h2>

        <!-- <a href="/report/siswa/{{$siswa->id}}">
            <button
                class="flex items-right justify-between w-22 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Report
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </a> -->
    </div>

    <div class="flex items-center justify-center">
        <div class="w-1/2">
            <canvas class="p-10" width="10px" height="10px" id="chartKasar"></canvas>
            <div class="py-3 px-5 text-center">Motorik Kasar</div>
        </div>
        <div class="w-1/2">
            <canvas class="p-10" width="10px" height="10px" id="chartHalus"></canvas>
            <div class="py-3 px-5 text-center">Motorik Halus</div>
        </div>
    </div>
</div>

<div class="px-4 py-3 m-8 bg-white rounded-lg shadow-md dark:bg-gray-800 bg-opacity-90">
    <div class="flex items-center justify-between mx-6">
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
            Nilai Motorik: {{$siswa->nama_lengkap}}
        </h2>

        <a href="/siswa/detail/{{$siswa->id}}/aktifitas">
            <button
                class="flex items-right justify-between w-20 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                New
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </a>
    </div>

    <div class="grid gap-6 mb-8 xs:grid-cols-2 xl:grid-cols-1 bg-white dark:bg-gray-800 rounded-lg p-4 bg-opacity-95">
        <livewire:livewire-aktifitas-siswa :user_id="$siswa->id" />
    </div>
</div>

<!-- Required chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart radar -->
<script>
    const dataRadarKasar = {
        labels: ["{!! implode('","', $spider['spider_kasar']) !!}"],
        datasets: [{
                label: "Data Sebelumnya",
                data: [{{implode(',', $spider['spider_before']['motorik_kasar'])}}],
                fill: true,
                backgroundColor: "rgba(133, 105, 241, 0.2)",
                borderColor: "rgb(133, 105, 241)",
                pointBackgroundColor: "rgb(133, 105, 241)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgb(133, 105, 241)",
            },
            {
                label: "Data Terbaru",
                data: [{{implode(',', $spider['spider_latest']['motorik_kasar'])}}],
                fill: true,
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgb(54, 162, 235)",
                pointBackgroundColor: "rgb(54, 162, 235)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgb(54, 162, 235)",
            },
        ],
    };
    
    const dataRadarHalus = {
        labels: ["{!! implode('","', $spider['spider_halus']) !!}"],
        datasets: [{
                label: "Data Sebelumnya",
                data: [{{implode(',', $spider['spider_before']['motorik_halus'])}}],
                fill: true,
                backgroundColor: "rgba(133, 105, 241, 0.2)",
                borderColor: "rgb(133, 105, 241)",
                pointBackgroundColor: "rgb(133, 105, 241)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgb(133, 105, 241)",
            },
            {
                label: "Data Terbaru",
                data: [{{implode(',', $spider['spider_latest']['motorik_halus'])}}],
                fill: true,
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgb(54, 162, 235)",
                pointBackgroundColor: "rgb(54, 162, 235)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgb(54, 162, 235)",
            },
        ],
    };


    const configRadarHalus = {
        type: "radar",
        data: dataRadarHalus,
        options: {
            scale: {
                min: 0,
                max: 5,
                stepSize: 1,
            },
        },
    };

    const configRadarKasar = {
        type: "radar",
        data: dataRadarKasar,
        options: {
            scale: {
                min: 0,
                max: 5,
                stepSize: 1,
            },
        },
    };

    var chartBar = new Chart(
        document.getElementById("chartHalus"),
        configRadarHalus
    );

    var chartBar2 = new Chart(
        document.getElementById("chartKasar"),
        configRadarKasar
    );

</script>

@endsection