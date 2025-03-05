<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class Screening extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'movie_id',
        'theater_id'
    ];

    public function getImageFullUrlAttribute()
    {
        
        if ($this->id && Storage::exists("public/theaters/" . $this->theater_id . ".png")) {
            return asset("storage/theaters/" . $this->theater_id . ".png");
        } else {
           return asset("storage/theaters/_no_poster_1.png");
        }
    }

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::Class);
    }

    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::Class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::Class);
    }
}
