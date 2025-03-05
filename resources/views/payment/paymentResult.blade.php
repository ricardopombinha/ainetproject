@extends('layouts.main')

@section('header-title', 'Payment Details')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

        
            <h1 class="text-xl my-6 text-gray-700 dark:text-gray-300">Compra efetuada com <strong>SUCESSO</strong>, será redirecionado
                para a pagina principal. Espere pelo download dos receipts, bilhetes e redirecionamento da pagina </h1>

            <meta http-equiv="refresh" content='5;url="{{ route("pdfs.generateTicket",
                    ["purchase" => $purchase]) }}"'>

        
            

        </div>

        
    </div>
@endsection