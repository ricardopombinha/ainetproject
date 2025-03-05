@extends('layouts.main')

@section('header-title', $screening->movie->title . ' In ' . $screening?->theater?->title . $screening->date . $screening->start_time)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('screenings.show', ['screening' => $screening]) }}"
                        text="View"
                        type="info"/>
                    <form method="POST" action="{{ route('screenings.destroy', ['screening' => $screening]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Screening "{{ $screening->movie->title }}" in "{{ $screening?->theater?->name }}" {{ $screening->date }} {{ $screening->start_time }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('screenings.update', ['screening' => $screening]) }}"
                        enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mt-6 space-y-4">
                        @include('screening.shared.fields', ['mode' => 'show'])
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection