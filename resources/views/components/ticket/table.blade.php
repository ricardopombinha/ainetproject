<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Customer Name</th>
            <th class="px-2 py-2 text-left">Movie</th>
            <th class="px-2 py-2 text-right">Theater</th>
            <th class="px-2 py-2 text-left">Seat</th>
            <th class="px-2 py-2 text-left">See ticket</th>
            <th class="px-2 py-2 text-left">Download ticket</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tickets as $ticket)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $ticket->purchase?->customer?->user?->name }}</td>
                <td class="px-2 py-2 text-left">{{ $ticket->screening->movie->title }}</td>
                <td class="px-2 py-2 text-right">{{ $ticket?->screening?->theater?->name }}</td>
                <td class="px-2 py-2 text-left">{{ $ticket?->seat?->row }}{{ $ticket?->seat?->seat_number }}</td>
                <td>
                    <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('tickets.myTickets.html', ['ticket' => $ticket]) }}"/>
                </td>
                <td>
                    @if($ticket->status == 'valid')
                    <form method="GET" action="{{ route('pdfs.downloadTicket', ['ticket' => $ticket]) }}">
                        @csrf
                        <x-button
                            element="submit"
                            text="Download"
                            type="danger"/>
                    </form>
                    @else
                    Não valido
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
