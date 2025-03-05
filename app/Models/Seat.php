<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    public $timestamps = false;
    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::Class);
    }

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::Class);
    }
}
