<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Movie name</th>
            <th class="px-2 py-2 text-right">Date</th>
            <th class="px-2 py-2 text-right">Start time</th>
            <th class="px-2 py-2 text-left"></th>
            <th class="px-2 py-2 text-left"></th>
            <th class="px-2 py-2 text-left"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($screenings as $screening)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $screening->movie->title}}</td>
                <td class="px-2 py-2 text-right">{{ $screening->date}}</td>
                <td class="px-2 py-2 text-right">{{ $screening->start_time}}</td>
                <td>
                    <x-table.icon-show class="ps-3 px-0.5"
                    href="{{ route('screenings.show', ['screening' => $screening]) }}"/>
                </td>
                <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                </td>
                <td>
                    <x-table.icon-delete class="px-0.5"
                    action="{{ route('screenings.destroy', ['screening' => $screening]) }}"/>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>