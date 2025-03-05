<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Movie name</th>
            <th class="px-2 py-2 text-right">Genre</th>
            <th class="px-2 py-2 text-right">Year</th>
            <th class="px-2 py-2 text-left"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($movies as $movie)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $movie->title}}</td>
                <td class="px-2 py-2 text-right">{{ $movie->genre->name}}</td>
                <td class="px-2 py-2 text-right">{{ $movie->year}}</td>
                <td>
                    <form method="GET" action="{{ route('screenings.createScreening', ['movie' => $movie]) }}">
                        @csrf
                        <x-button
                            element="submit"
                            text="Confirm"
                            type="success"/>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>