@extends('layouts.main')

@section('header-title', "Create new Screening")

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Create Screening
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('screenings.store', ['movie' => $movie]) }}">
                    @csrf
                    <div class="mt-6 space-y-4">
                        <div class="flex flex-wrap space-x-8">
                            <div class="grow mt-6 space-y-4">
                                <x-field.input name="date" type="date" label="Day of the Screening" 
                                        value="{{ old('date', $screening->date) }}"/>
                    
                                <div class="flex space-x-4">
                                    <p>Choose the time of screening<p>
                                    <x-field.checkbox name="time13" label="13:00:00"
                                        />
                                    <x-field.checkbox name="time14" label="14:00:00"
                                        />
                                    <x-field.checkbox name="time16" label="16:00:00"
                                        />
                                    <x-field.checkbox name="time19" label="19:00:00"
                                        />
                                    <x-field.checkbox name="time21" label="21:00:00"
                                        />
                                    <x-field.checkbox name="time22" label="22:00:00"
                                        />
                                </div>
                                <x-field.select name="theater" label="Choose Theater" 
                                value="{{ old('theater', $screening->theater_id) }}"
                                :options="$theaters"/>
                                <x-field.select name="timeFrame" label="Time of Frame" 
                                        value="{{ old('timeFrame') }}"
                                        :options="[
                                            'Once a Week' => 'Once a Week',
                                            'Every Day' => 'Every Day',
                                            'Once a month' => 'Once a month',
                                        ]"/>
                                <x-field.input name="dateLast" type="date" label="Last Day of Screening" 
                                    value="{{ old('dateLast') }}"/>
        
                            </div>

                        </div>
                    </div>
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                        
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection