@extends('layouts.main')

@section('header-title', 'Create Screening, choose movies')

@section('main')
    <div class="flex justify-center">

        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

                
                <x-movie.filter-card
                    :filterAction="route('screenings.create')"
                    :resetUrl="route('screenings.create')"
                    :title="old('title', $filterByTitle)"
                    class="mb-6"
                    />

            
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-screening.movieTable :movies="$movies"
                    />
            </div>

            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
@endsection