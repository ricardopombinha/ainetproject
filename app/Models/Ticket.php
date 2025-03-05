<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'seat_id',
        'purchase_id',
        'price'
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::Class);
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::Class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::Class);
    }
}
