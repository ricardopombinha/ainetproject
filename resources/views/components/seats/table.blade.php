<div {{ $attributes }}>

    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Movie</th>
            <th class="px-2 py-2 text-right">Date</th>
            <th class="px-2 py-2 text-right">Start Time</th>
            <th class="px-2 py-2 text-right">Row</th>
            <th class="px-2 py-2 text-left">Seat</th>
            @if($showAddToCart)
                <th></th>
            @endif
            @if($showRemoveFromCart)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($seats as $seat)
            
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $screening->movie->title }}</td>
                <td class="px-2 py-2 text-right">{{ $screening->date }}</td>
                <td class="px-2 py-2 text-right">{{ $screening->start_time }}</td>
                <td class="px-2 py-2 text-right">{{ $seat->row }}</td>
                <td class="px-2 py-2 text-left">{{ $seat->seat_number }}</td>
                <td class="px-2 py-2 text-center"> 
                @if($showAddToCart)
                <td>
                <x-table.icon-add-cart class="px-0.5"
                    method="POST"
                    action="{{ route('cart.add', ['seat' => $seat, 'screening' => $screening]) }}"/>
                </td>
                @endif
                @if($showRemoveFromCart)
                <td>
                <x-table.icon-minus class="px-0.5"
                    method="delete"
                    action="{{ route('cart.remove', ['seat' => $seat, 'screening' => $screening]) }}"/>
                </td>
                @endif

            </tr>
        @endforeach
        </tbody>
        
    </table>

    
</div>