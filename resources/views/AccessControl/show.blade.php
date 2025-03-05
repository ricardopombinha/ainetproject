@extends('layouts.main')

@section('header-title', 'Access Control: ' . $screening->movie->title . ', ' . $screening->date .', ' . $screening->start_time . ', ' . $screening->theater->name)

@section('main')

<!-- devolver de novo o screening  -->

<style>
h1 {
    color: #dddddd;
    font-size: 2em; /* tamanho */
    text-align: center;
}
</style>

<h1>Insira o Ticked ID</h1>



<form method="POST" action="{{ route('access.validateTicket', ['screening' => $screening]) }}">
    @csrf
    <div class="flex flex-wrap space-x-8">
        <div class="grow mt-6 space-y-4">
          <x-field.input name="ticket_id"  label="Ticket ID"
            :value="old('ticket_id')"/>
        </div>
    </div> 

    <div class="mt-6">
        <x-button
            element="submit"
            text="Submit"
            type="cofirmation"
        />

    </div>
</form>


@endsection
