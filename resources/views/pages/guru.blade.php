@extends('pages.app')

@section('content')
<div class="container px-6 mx-auto grid">
<div class="flex items-center justify-between">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Guru
        </h2>

        <a href="/guru/create">
            <button
                class="flex items-right justify-between w-20 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                New
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </a>
    </div>

    <!-- Cards -->
    <div class="grid gap-6 mb-8 xs:grid-cols-2 xl:grid-cols-1 bg-white dark:bg-gray-800 rounded-lg p-4 bg-opacity-95">
        <livewire:livewire-guru />
    </div>
</div>
@endsection