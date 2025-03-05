@php
 $mode = $mode ?? 'edit';
 $readonly = $mode == 'show';
@endphp

@extends('layouts.main')

@section('header-title', 'Profile')

@section('main')
<div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                    <x-button
                        href="{{ route('profile.editUser', ['user' => $user]) }}"
                        text="View"
                        type="info"/>
                    <br>
                        @include('profile.partials.update-profile-information-form', ['mode' => 'show','admin_access' => 'True'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection