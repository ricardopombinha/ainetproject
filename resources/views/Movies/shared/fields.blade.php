@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title" width="md"
                        :readonly="$readonly"
                        value="{{ old('title', $movie->title) }}"/>
        <x-field.radio-group name="genre" label="Type of genre" :readonly="$readonly"
                        value="{{ old('genre', $movie->genre_code) }}"
                        :options="$genres"/>
        <x-field.input name="year" label="Year" :readonly="$readonly"
                        value="{{ old('year', $movie->year) }}"/>
        <x-field.input name="trailer_url" label="Trailer Url" :readonly="$readonly"
                    value="{{ old('trailer_url', $movie->trailer_url) }}"/>
        
    
        <x-field.text-area name="synopsis" label="Synopsis" :readonly="$readonly"
                            value="{{ old('synopsis', $movie->synopsis) }}"/>
        
    </div>
    <div class="pb-6">
        <x-field.image
            name="image_file"
            label="Movie Poster"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Poster"
            :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
            deleteForm="form_to_delete_image"
            :imageUrl="$movie->ImageFullUrl"/>
    </div>
</div>