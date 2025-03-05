@extends('layouts.main')

@section('header-title', 'List of Movies')

@section('main')
    <div class="flex justify-center">

    
            
        
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            
                <x-movie.filter-card
                    :filterAction="route('movies.management.index')"
                    :resetUrl="route('movies.management.index')"
                    :title="old('title', $filterByTitle)"
                    class="mb-6"
                    />

            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('movies.create') }}"
                    text="Create a new Movie"
                    type="success"/>
            </div>
            
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-movie.table :movies="$movies"
                    />
            </div>

            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
@endsection