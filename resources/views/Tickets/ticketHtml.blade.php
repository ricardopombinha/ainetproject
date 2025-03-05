@extends('layouts.main')

@section('header-title', 'Informações de Ticket')

@section('main')
    
<div class="flex items-center justify-center min-h-screen bg-white dark:bg-gray-900">
    <div class="ticket max-w-3xl bg-white dark:bg-gray-800 border border-gray-800 rounded-lg p-8 shadow-lg">
        <div class="header text-center border-b border-gray-300 pb-6 mb-6">
            <h1 class="text-4xl font-bold text-gray-500 dark:text-gray-400"> {{ $ticket->screening->movie->title }} </h1>
            <p class="text-xl mt-2 font-bold text-gray-500 dark:text-gray-400">Date of screening:  {{ $ticket->screening->date }} {{$ticket->screening->start_time}} </p>
            <p class="text-xl mt-2 font-boldtext-gray-500 dark:text-gray-400 ">Ticket ID:  {{ $ticket->id }} </p>
            @if($ticket->status == 'valid')
            <p class="text-xl mt-2 font-boldtext-gray-500 dark:text-green-400 ">Valido </p>
            @else
            <p class="text-xl mt-2 font-boldtext-gray-500 dark:text-red-400 ">Invalido </p>
            @endif
            
        </div>
        <div class="info flex justify-between border-b border-gray-300 pb-6 mb-6">
            <div class="details text-lg">
                <p class='text-gray-500 dark:text-gray-400' ><strong>Name:</strong>  {{ $ticket->purchase->customer_name }} </p>
                <p class='text-gray-500 dark:text-gray-400'><strong>Email:</strong>  {{ $ticket->purchase->customer_email }}</p>
                <p class='text-gray-500 dark:text-gray-400'><strong>Theater:</strong> {{ $ticket->screening->theater->name }} </p>
                <p class='text-gray-500 dark:text-gray-400'> <strong>Seat:</strong>  {{ $ticket->seat->row }}{{ $ticket->seat->seat_number }} </p>
            </div>
            <div class="photo w-32 h-32 ml-8">
                <img class="w-full h-full rounded-full object-cover" src="$ticket->purchase->customer->user->photoFullUrl" alt="Photo of John Doe">
            </div>
        </div>
        

        @if($ticket->status == 'valid')
            @if(Auth::user()->type == 'E')
                <div class="mt-6 flex justify-center space-x-4">
                    <form method="POST" action="{{ route('access.ticketInvalidate',  ['ticket' => $ticket]) }}">
                        @csrf
                        <x-button element="submit" type="success" text="Permitir accesso" class="uppercase"/>
                    </form>
                    <form method="POST" action="{{ route('access.ticketInvalidate',  ['ticket' => $ticket]) }}">
                        @csrf
                        <x-button element="submit" type="danger" text="Negar accesso" class="uppercase"/>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div> 

@endsection