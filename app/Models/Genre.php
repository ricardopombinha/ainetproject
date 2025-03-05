<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Genre;

class Genre extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    public $timestamps = false;
    
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name'
    ];
    public $incrementing = false;

    protected $keyType = 'string';

    public function movie(): HasMany
    {
        return $this->hasMany(Movie::Class,'genre_code','id');
    }
}
