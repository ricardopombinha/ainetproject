<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Data</th>
            <th class="px-2 py-2 text-left">Hora</th>
            <th class="px-2 py-2 text-left">Theater</th>
            <th class="px-2 py-2 text-right">   </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($screenings as $screening)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $screening->date }}</td>
                <td class="px-2 py-2 text-left">{{ $screening->start_time }}</td>
                <td class="px-2 py-2 text-left">{{ $screening->theater->name }}</td>
                <td class="px-2 py-2 text-right"> 
                    @if (count($screening->ticket) != count($screening->theater->seat))
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-40" href="{{ route('tickets.seats', ['screening' => $screening]) }}">
                                        Comprar bilhete
                                   </a> 
                    @else
                    Sold Out
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>