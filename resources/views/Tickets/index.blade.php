@extends('layouts.main')

@section('header-title', 'Buy a Ticket')

@section('main')
    
    
<div>
    <figure class="h-auto md:h-72 flex flex-col md:flex-row
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900 
                    my-4 p-8 md:p-0">
        <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72  mx-auto" href="./curricula.html">
            <img class="h-full aspect-auto mx-auto rounded-full md:rounded-l-xl md:rounded-r-none" src="{{ $movie->imageFullUrl }}">
        </a>
        <div class="h-auto p-6 text-center md:text-left space-y-1 flex flex-col">
            <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight" href="./curricula.html">
            {{ $movie->title }}
            </a>
            <figcaption class="font-medium">
                <div class="flex justify-center md:justify-start font-base text-base space-x-6 text-gray-700 dark:text-gray-300">
                    <div>{{ $movie->year }}</div>
                    <div>{{ $movie->gender_code }}</div>
                </div>
            </figcaption>
            <p class="pt-4 font-light text-gray-700 dark:text-gray-300 overflow-y-auto">
                {{ $movie->synopsis }}
            </p>
        </div>

        <br>
    </figure>
</div>
    
@endsection