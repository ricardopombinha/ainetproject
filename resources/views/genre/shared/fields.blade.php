@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        
        <x-field.input name="name" label="Name" :readonly="$readonly"
                        value="{{ old('name', $genre->name) }}"/>
    </div>
    
</div>