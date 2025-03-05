@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        New theater
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('theaters.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @include('theaters.shared.fields', ['mode' => 'create'])
                    <div class="pb-6">
                        <x-field.input name="rows" label="Number of Rows" 
                            value="{{ old('rows') }}"/>
                    </div>
                    <div class="pb-6">
                        <x-field.input name="seats" label="Number Of seats per Row" 
                            value="{{ old('seats') }}"/>
                    </div>
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save new Theater" class="uppercase"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection