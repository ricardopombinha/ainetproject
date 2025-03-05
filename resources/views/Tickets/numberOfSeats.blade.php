@extends('layouts.main')

@section('header-title', 'Buy a Ticket')

@section('main')


<figure class="h-auto md:h-72 flex flex-col md:flex-row
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900 
                    my-4 p-8 md:p-0">
        <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72  mx-auto" href="./curricula.html">
            <img class="h-full aspect-auto mx-auto rounded-full md:rounded-l-xl md:rounded-r-none" src="{{ $screening->movie->imageFullUrl }}">
        </a>
        <div class="h-auto p-6 text-center md:text-left space-y-1 flex flex-col">
            <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight" href="./curricula.html">
            {{ $screening->movie->title }}
            </a>
            <figcaption class="font-medium">
                <div class="flex justify-center md:justify-start font-base text-base space-x-6 text-gray-700 dark:text-gray-300">
                    <div>{{ $screening->movie->year }}</div>
                    <div>{{ $screening->movie->gender_code }}</div>
                    <div>INFO C</div>
                </div>
                <address class="font-light text-gray-700 dark:text-gray-300">
                    <a href="mailto:coord.ti.tesp.estg@ipleiria.pt">coord.ti.tesp.estg@ipleiria.pt</a>.
                </address>
            </figcaption>
            <p class="pt-4 font-light text-gray-700 dark:text-gray-300 overflow-y-auto">
                {{ $screening->movie->synopsis }}
            </p>

            <br>
            <p class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            Theater : {{ $screening->theater->name }}
            </p>

            <p class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            Date : {{ $screening->date }}
            </p>

            <p class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            Date : {{ $screening->start_time }}
            </p>
            
        </div>

        <br>
    </figure>

    <div class= "h-auto md:h-12 flex flex-col md:flex-row
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900 
                    my-4 p-8 md:p-0 justify-center">
        <form action="{{ route('tickets.seats', ['screening' => $screening]) }}" method="POST">
            @csrf
            <label for="valor">Número de lugares:</label>
            <input class='border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm' type="text" id="valor" name="valor">

        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-40" type="submit">Confirmar</button>
    </div> 

</form>

@endsection