@extends('layouts.main')

@section('header-title', $movie->name)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
            <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="edit"
                        type="Primary"/>
                    <form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Movie "{{ $movie->title }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>
                @include('movies.shared.fields', ['mode' => 'show'])    
                
            </section>
        </div>
    </div>
</div>

@endsection