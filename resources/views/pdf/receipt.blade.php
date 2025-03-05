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
</div>

</body>
</html>