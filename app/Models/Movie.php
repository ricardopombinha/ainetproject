<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function getImageFullUrlAttribute()
    {
        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
           return asset("storage/posters/_no_poster_1.png");
        }
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::Class,'genre_code','code');
    }

    public function screening(): HasMany
    {
        return $this->hasMany(Screening::Class);
    }
}
