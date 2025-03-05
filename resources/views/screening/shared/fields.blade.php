@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="date" type="date" label="Day of the Screening" :readonly="$readonly"
                        value="{{ old('date', $screening->date) }}"/>
        <x-field.radio-group name="time" label="Time of the Screening" :readonly="$readonly"
                    value="{{ old('time', $screening->time_start) }}"
                    :options="[
                        '13:00:00' => '13:00:00',
                        '14:00:00' => '14:00:00',
                        '16:00:00' => '16:00:00',
                        '19:00:00' => '19:00:00',
                        '21:00:00' => '21:00:00',
                        '22:00:00' => '22:00:00',
                    ]"/>
        
    </div>

</div>