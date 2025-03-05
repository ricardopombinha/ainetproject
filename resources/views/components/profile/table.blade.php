<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-right">Number</th>
            <th class="px-2 py-2 text-left">Name</th>
            @if($showType)
                <th class="px-2 py-2 text-left hidden md:table-cell">Type</th>
            @endif
            <th class="px-2 py-2 text-left hidden lg:table-cell">Email</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-right">{{ $user->id }}</td>
                <td class="px-2 py-2 text-left">{{ $user->name }}</td>
                @if($showType)
                    <td class="px-2 py-2 text-left hidden md:table-cell">{{ $user->type }}</td>
                @endif
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $user->email }}</td>
                @if($user->type == 'C')
                <td>
                    <form method="POST" action="{{ route('profile.blockUser', ['user' => $user]) }}">
                        @csrf
                        @method('patch')
                        @if($user->blocked)
                        <x-button
                                value="1"
                                element="submit"
                                text="Block"
                                type="warning"/>
                        @else
                        <x-button
                                value="0"
                                element="submit"
                                text="Unblock"
                                type="success"/>    
                        @endif
                    </form>
                </td>
                <td>
                    <x-table.icon-delete class="px-0.5"
                        action="{{ route('profile.destroyByAdmin', ['user' => $user]) }}"/>
                </td>
                <td></td>
                @else
                    @if($showView)
                        @can('viewAny', App\Models\User::class)
                            <td>
                                <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('profile.show', ['user' => $user]) }}"/>
                            </td>
                        @endcan
                    @endif
                    @if($showEdit)
                        @can('viewAny', App\Models\User::class)
                            <td>
                                <x-table.icon-edit class="px-0.5"
                                href="{{ route('profile.editUser', ['user' => $user]) }}"/>
                            </td>
                        @endcan
                    @endif
                    @if($showDelete)
                        @if($user->id != Auth::user()->id)
                        @can('viewAny', App\Models\User::class)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('profile.destroyByAdmin', ['user' => $user]) }}"/>
                        </td>
                        @endcan
                        @else
                        <td></td>
                        @endif
                    @endif
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
