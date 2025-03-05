@extends('layouts.main')

@section('header-title', 'Choose of seats')

@section('main')
    
    
<div>
        
        <p class="text-center font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $screening->movie->title }}
        </p>
        <p class="text-center text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $screening->date }}
        </p>
        <p class="text-center text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $screening->start_time }}
        </p>

        <img class="w-80 h-72 aspect-auto mx-auto rounded-full md:rounded-l-xl md:rounded-r-none" src="{{ $screening->imageFullUrl }}">
    

        <br>
        

        <div class="flex justify-center">
            <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
                    <x-seats.table
                    :seats="$seats"
                    :screening="$screening"
                    :showAddToCart="true"
                    :showRemoveFromCart="false"
                />
            </div>
        </div>

        <div class="flex justify-center items-center text-center">
            <a class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-40" href="{{ route('cart.show') }}">
                    Carrinho
            </a> 
        </div>

        
    

</div>
    
@endsection