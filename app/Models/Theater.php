<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Theater extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    public $timestamps = false;
    public function seat(): HasMany
    {
        return $this->hasMany(Seat::Class);
    }

    public function screening(): HasMany
    {
        return $this->hasMany(Screening::Class);
    }


    public function getPhotoFullUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/theaters/{$this->photo_filename}")) {
            return asset("storage/theaters/{$this->photo_filename}");
        } else {
            return asset("storage/theaters/default.png");
        }
    }
}
