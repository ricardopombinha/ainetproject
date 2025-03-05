@extends('layouts.main')

@section('header-title', 'Access Control')

@section('main')

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #FFFAFA;
}
tr:nth-child(odd) {
  background-color: #ADD8E6;
}
</style>

@foreach ($screenings as $screening)
<div class="flex justify-end mb-6">
    <figure class="h-auto w-full md:h-72 flex flex-col md:flex-row
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900 
                    my-4 p-8 md:p-0">
        <div class="flex flex-col items-center md:items-end md:mr-6">
            <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72">
                <img class="h-full aspect-auto rounded-full md:rounded-l-xl md:rounded-r-none" src="{{ $screening->movie->imageFullUrl }}">
            </a>
        </div>
        <div class="h-auto p-6 text-center md:text-right space-y-4 flex flex-col items-center md:items-start w-full">
            <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                {{ $screening->movie->title }}
            </a>
            <figcaption class="font-medium">
                <div class="flex flex-col md:flex-row justify-center md:justify-end font-base text-base space-x-6 text-gray-700 dark:text-gray-300">
                    <div>{{ $screening->movie->genre_code }}</div>
                    <div>{{ $screening->movie->year }}</div>
                </div>
            </figcaption>

            <figcaption class="font-medium">
                <div class="flex flex-col md:flex-row justify-center md:justify-end font-base text-base space-x-6 text-gray-700 dark:text-gray-300">
                    <div>Screening Date: {{ $screening->date }}</div>
                    <div>Time: {{ $screening->start_time }}</div>
                </div>
            </figcaption>

            <x-button
            href="{{ route('access.show', ['screening' => $screening]) }}"
            text="Access Control"
            type="success"/>
        
        </div>
    </figure>
   
</div>
@endforeach

<div class="mt-4">
  {{$screenings->links()}}
</div>

@endsection
