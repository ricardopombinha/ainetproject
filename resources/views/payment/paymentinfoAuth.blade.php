@extends('layouts.main')

@section('header-title', 'Payment Details')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

            <form method="POST" action="{{ route('paymentfinalinfo.show') }}">
                @csrf

                <input type="hidden" name="name" value="{{ $dados['name'] }}">
                <input type="hidden" name="email" value="{{ $dados['email'] }}">
                <input type="hidden" name="nif" value="{{ $dados['nif'] }}">
                <input type="hidden" name="paymenttype" value="{{ $dados['paymenttype'] }}">

                <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Name: </strong>{{ $dados['name']}}</h2>
                <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Email: </strong>{{ $dados['email']}}</h2>
                <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>NIF: </strong>{{ $dados['nif']}}</h2>
                <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment Type: </strong>{{ $dados['paymenttype']}}</h2>
                
                
                @if ($dados['paymenttype'] === 'MBWAY')
                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
                    </div>
                @elseif ($dados['paymenttype'] === 'PAYPAL')
                    <div class="mt-4">
                        <x-input-label for="paypal_email" :value="__('Paypal Email')" />
                        <x-text-input id="paypal_email" class="block mt-1 w-full" type="email" name="paypal_email" :value="old('paypal_email')"/>
                    </div>
                @elseif ($dados['paymenttype'] === 'VISA')
                    <div class="mt-4">
                        <x-input-label for="visa_card_number" :value="__('Visa Card Number')" />
                        <x-text-input id="visa_card_number" class="block mt-1 w-full" type="text" name="visa_card_number" :value="old('visa_card_number')"/>
                        <x-input-label for="visa_ccv" :value="__('Visa CCV')" />
                        <x-text-input id="visa_ccvr" class="block mt-1 w-full" type="text" name="visa_ccv" :value="old('visa_ccv')"/>
                    </div>
                @endif
                



                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ 'Submit' }}
                    </x-primary-button>
                </div>
            
            </form>
            

        </div>
    </div>
@endsection