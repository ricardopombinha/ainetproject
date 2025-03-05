<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Theater Name</th>
            <th class="px-2 py-2 text-left"></th>
            <th class="px-2 py-2 text-left"></th>
            <th class="px-2 py-2 text-left"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($theaters as $theater)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $theater->name}}</td>
                <td>
                    <x-table.icon-show class="ps-3 px-0.5"
                    href="{{ route('theaters.show', ['theater' => $theater]) }}"/>
                </td>
                <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('theaters.edit', ['theater' => $theater]) }}"/>
                </td>
                <td>
                    <x-table.icon-delete class="px-0.5"
                    action="{{ route('theaters.destroy', ['theater' => $theater]) }}"/>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>