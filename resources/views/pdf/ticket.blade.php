<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-200">
    <div class="ticket max-w-3xl bg-white border border-gray-800 rounded-lg p-8 shadow-lg">
        <div class="header text-center border-b border-gray-300 pb-6 mb-6">
            <h1 class="text-4xl font-bold">{{ $movie_name }}</h1>
            <p class="text-xl mt-2 font-bold">Date of screening: {{ $screening }}</p>
            <p class="text-xl mt-2 font-bold">Ticket ID: {{ $ticket_id }}</p>
            <p class="text-xl mt-2 font-bold text-green-500">Ticket is still valid</p>
        </div>
        <div class="info flex justify-between border-b border-gray-300 pb-6 mb-6">
            <div class="details text-lg">
                <p><strong>Name:</strong> {{ $user_name }}</p>
                <p><strong>Email:</strong> {{ $email}}</p>
                <p><strong>Theater:</strong> {{ $theater_name }}</p>
                <p><strong>Seat:</strong> {{ $seat }}</p>
            </div>
            <div class="photo w-32 h-32 ml-8">
                <img class="w-full h-full rounded-full object-cover" src="photo.jpg" alt="Photo of John Doe">
            </div>
        </div>
        <div class="qr-code text-center my-12">
            <img class="w-40 h-40 mx-auto" src="qrcode.png" alt="QR Code">
        </div>
    </div>
</body>
</html>