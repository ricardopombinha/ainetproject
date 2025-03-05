<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="max-w-2xl mx-auto bg-white p-6 my-10 shadow-lg">

    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Receipt</h1>
        <p class="text-gray-600">Purchase Number: <span id="purchase-number">{{ $purchase_id }}</span></p>
        <p class="text-gray-600">Date of Purchase: <span id="purchase-date">{{ $date }}</span></p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Payment Details</h2>
        <table class="w-full border-collapse border border-gray-300">
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Payment Type</th>
                <td class="border border-gray-300 px-4 py-2" id="payment-type">{{ $payment_type }}</td>
            </tr>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Payment Reference</th>
                <td class="border border-gray-300 px-4 py-2" id="payment-reference">{{ $payment_reference }}</td>
            </tr>
        </table>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Customer Information</h2>
        <table class="w-full border-collapse border border-gray-300">
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                <td class="border border-gray-300 px-4 py-2" >{{ $customer_name }}</td>
            </tr>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                <td class="border border-gray-300 px-4 py-2" >{{ $customer_email }}</td>
            </tr>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">NIF</th>
                <td class="border border-gray-300 px-4 py-2" >{{ $customer_nif }}</td>
            </tr>
        </table>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Tickets</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Ticket ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                </tr>
            </thead>
            <tbody id="ticket-list">
                @foreach($tickets as $ticket)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-right text-xl font-semibold mb-6">
        <p>Total Price: <span id="total-price">{{ $price_total }}</span></p>
    </div>

    <div class="text-center">
        <p class="text-gray-600">Thank you for your purchase!</p>
    </div>
    

    @foreach($tickets as $ticket)
        <div class="page-break"></div>
        <div class="ticket max-w-3xl bg-white border border-gray-800 rounded-lg p-8 shadow-lg">
            <div class="header text-center border-b border-gray-300 pb-6 mb-6">
                <h1 class="text-4xl font-bold">{{ $ticket->screening->movie->title }}</h1>
                <p class="text-xl mt-2 font-bold">Date of screening: {{ $ticket->screening->date }} {{ $ticket->screening->start_time}}</p>
                <p class="text-xl mt-2 font-bold">Ticket ID: {{ $ticket->id }}</p>
            </div>
            <div class="info flex justify-between border-b border-gray-300 pb-6 mb-6">
                <div class="details text-lg">
                    <p><strong>Name:</strong> {{ $ticket->purchase->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $ticket->purchase->customer_email}}</p>
                    <p><strong>Theater:</strong> {{ $ticket->screening->theater->name }}</p>
                    <p><strong>Seat:</strong> {{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}</p>
                </div>
                <div class="photo w-32 h-32 ml-8">
                    <img class="w-full h-full rounded-full object-cover" src="photo.jpg" alt="Photo of John Doe">
                </div>
            </div>
            <div class="qr-code text-center my-12">
                <img class="w-40 h-40 mx-auto" src="qrcode.png" alt="QR Code">
            </div>
        </div>
        
    @endforeach

</div>

</body>
</html>