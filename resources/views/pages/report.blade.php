@extends('pages.app')

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex items-center justify-between">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Report
        </h2>
    </div>

    <!-- Cards -->
    <div class="grid gap-6 mb-8 xs:grid-cols-2 xl:grid-cols-1 bg-white dark:bg-gray-800 rounded-lg p-4 bg-opacity-95">
        <h2 class="text-xl font-bold text-gray-700 dark:text-gray-200 text-center">
            Kegiatan
        </h2>
        <livewire:livewire-aktifitas-siswa exportable/>
    </div>

    <!-- Cards -->
    <div class="grid gap-6 mb-8 xs:grid-cols-2 xl:grid-cols-1 bg-white dark:bg-gray-800 rounded-lg p-4 bg-opacity-95">
        <h2 class="text-xl font-bold text-gray-700 dark:text-gray-200 text-center">
            Pelajaran
        </h2>
        <livewire:livewire-nilai-siswa exportable/>
    </div>
</div>
@endsection