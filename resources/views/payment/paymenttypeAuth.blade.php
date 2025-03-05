@extends('layouts.main')

@section('header-title', 'Payment Details')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

            <form method="POST" action="{{ route('paymentinfo.showAuth') }}">
                @csrf


                <input type="hidden" name="name" value="{{ $dados['name'] }}">
                <input type="hidden" name="email" value="{{ $dados['email'] }}">
                <input type="hidden" name="nif" value="{{ $dados['nif'] }}">

                
                @auth

                <x-field.radio-group name="paymenttype" label="Choose Payment Type" :value="old('paymenttype', Auth::user()->customer->payment_type)"
                    :options="[
                    'MBWAY' => 'MBWay',
                    'VISA' => 'Visa',
                    'PAYPAL' => 'Paypal'
                    ]"/>
                
                @endauth
                

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ 'Submit' }}
                    </x-primary-button>
                </div>
            
            </form>
            

        </div>
    </div>
@endsection