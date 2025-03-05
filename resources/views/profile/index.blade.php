@extends('layouts.main')

@section('header-title', 'List of Users')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-profile.filter-card
                :filterAction="route('profile.index')"
                :resetUrl="route('profile.index')"
                :types="$typeOptions"
                :type="old('type', $filterByType)"
                :name="old('name', $filterByName)"
                class="mb-6"
                />
            @if(Auth::user()->type == 'A')
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('profile.create') }}"
                        text="Create a new User"
                        type="success"/>
                </div>
            @endif
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-profile.table :users="$users"
                    :showType="true"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection