<div {{ $attributes }}>

    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Movie</th>
            <th class="px-2 py-2 text-right">Theater</th>
            <th class="px-2 py-2 text-right">Date</th>
            <th class="px-2 py-2 text-right">Start Time</th>
            <th class="px-2 py-2 text-right">Row</th>
            <th class="px-2 py-2 text-left">Seat</th>
            <th class="px-2 py-2 text-left">Price</th>
            @if($showAddToCart)
                <th></th>
            @endif
            @if($showRemoveFromCart)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @php
            {{ $total=0; }}
            {{ $total_discount=0; }}
            {{ $flag = 0; }}
        @endphp
        @foreach ($seats as $screening_id => $seatsByScreening)

            @php
                $screening = $screenings[$screening_id];
            @endphp

            @foreach ($seatsByScreening as $seat)
            
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $screening->movie->title }}</td>
                <td class="px-2 py-2 text-right">{{ $screening->theater->name }}</td>
                <td class="px-2 py-2 text-right">{{ $screening->date }}</td>
                <td class="px-2 py-2 text-right">{{ $screening->start_time }}</td>
                <td class="px-2 py-2 text-right"><strong>{{ $seat->row }}</strong></td>
                <td class="px-2 py-2 text-left"><strong>{{ $seat->seat_number }}</strong></td>
                <td class="px-2 py-2 text-left"><strong>{{ $price }}.0 €</strong></td>
                @php
                    {{ $total= $total+ $price; }}
                    {{ $total_discount = $total_discount + $discount; }}
                @endphp
                <td class="px-2 py-2 text-center"> 
                @if($showAddToCart)
                <td>
                <x-table.icon-add-cart class="px-0.5"
                    method="POST"
                    action="{{ route('cart.add', ['seat' => $seat, 'screening' => $screening_id]) }}"/>
                </td>
                @endif
                @if($showRemoveFromCart)
                <td>
                <x-table.icon-minus class="px-0.5"
                    method="delete"
                    action="{{ route('cart.remove', ['seat' => $seat, 'screening' => $screening_id]) }}"/>
                </td>
                @endif
            </tr>
            @endforeach
        @endforeach
        
        </tbody>
        
    </table>

    @auth

    @php
    $flag = 1;
    if(Auth::user()->type == 'C'){
            $total_without_discount = $total;
            $total = $total -  $total_discount; 
            session()->put('total_price', $total);
            $ticket_with_discount = $price - $discount;
            session()->put('price', $ticket_with_discount);
    }else{
            $total_without_discount = $total;
            session()->put('total_price', $total);
            session()->put('price', $price);
        }
        
        
    @endphp
    

    <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Total:     </strong> {{$total_without_discount}}.0 €</h2>

    @if (Auth::user()->type == 'C')
    <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Total with discount({{$discount}}€ per ticket): </strong> {{$total}}.0 €</h2>
    @endif
    @endauth
    
    @if ($flag==0)
        @php
        $total_without_discount = $total;
            session()->put('total_price', $total);
            session()->put('price', $price);
        @endphp
        <h2 class="text-xl my-6 text-gray-700 dark:text-gray-300"><strong>Total:     </strong> {{$total_without_discount}}.0 €</h2>
    @endif
</div>

