@extends('layouts.main')

@section('header-title', 'Payment Details')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <!-- <h2 class="text-xl my-6">Payment Details</h2>-->
            

            <form method="POST" action="{{ route('paymenttype.show') }}">
                @csrf

                
                    <!-- Name -->
                <div>
                    <x-input-label for="name" :value="'Name'" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="'Email'" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- NIF -->
                <div class="mt-4">
                    <x-input-label for="nif" :value="'NIF'" />
                    <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif" :value="old('nif')" required autocomplete="nif" />
                    <x-input-error :messages="$errors->get('nif')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ 'Submit' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection