@extends('layouts.main')

@section('header-title', 'Payment Details')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

                <h1 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Confirm information:</strong></h1>
                <br>

                <form method="POST" action="{{ route( 'paymentResult.store' ) }}">

                @csrf

                    <input type="hidden" name="name" value="{{ $dados['name'] }}">
                    <input type="hidden" name="email" value="{{ $dados['email'] }}">
                    <input type="hidden" name="nif" value="{{ $dados['nif'] }}">
                    <input type="hidden" name="paymenttype" value="{{ $dados['paymenttype'] }}">

                    <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Name: </strong>{{ $dados['name']}}</h2>
                    <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Email: </strong>{{ $dados['email']}}</h2>
                    <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>NIF: </strong>{{ $dados['nif']}}</h2>
                    <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment : </strong>{{ $dados['paymenttype']}}</h2>
                    
                    @if ($dados['paymenttype'] === 'MBWAY')
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment Phone Number: </strong>{{ $dados['phone']}}</h2>
                        <input type="hidden" name="phone" value="{{ $dados['phone'] }}">
                    @elseif ($dados['paymenttype'] === 'PAYPAL')
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment Paypal Email: </strong>{{ $dados['paypal_email']}}</h2>
                        <input type="hidden" name="paypal_email" value="{{ $dados['paypal_email'] }}">
                    @elseif ($dados['paymenttype'] === 'VISA')
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment VISA Card Number: </strong>{{ $dados['visa_card_number']}}</h2>
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment VISA Card CCV: </strong>{{ $dados['visa_ccv']}}</h2>
                        <input type="hidden" name="visa_card_number" value="{{ $dados['visa_card_number'] }}">
                        <input type="hidden" name="visa_ccv" value="{{ $dados['visa_ccv'] }}">
                    @endif

                    @if ($dados['paymenttype'] === 'MBWay')
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment Phone Number: </strong>{{ $dados['phone']}}</h2>
                        <input type="hidden" name="phone" value="{{ $dados['phone'] }}">
                    @elseif ($dados['paymenttype'] === 'Paypal')
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment Paypal Email: </strong>{{ $dados['paypal_email']}}</h2>
                        <input type="hidden" name="paypal_email" value="{{ $dados['paypal_email'] }}">
                    @elseif ($dados['paymenttype'] === 'Visa')
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment VISA Card Number: </strong>{{ $dados['visa_card_number']}}</h2>
                        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Payment VISA Card CCV: </strong>{{ $dados['visa_ccv']}}</h2>
                        <input type="hidden" name="visa_card_number" value="{{ $dados['visa_card_number'] }}">
                        <input type="hidden" name="visa_ccv" value="{{ $dados['visa_ccv'] }}">
                    @endif



                    <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ 'Pay' }}
                    </x-primary-button>
                </div>
                </form">
            

        </div>
    </div>
@endsection