<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'nif',
        'payment_type',
        'payment_ref',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::Class, 'id','id');
    }

    public function purchase(): HasMany
    {
        return $this->hasMany(Purchase::Class);
    }

   /* public function getPaymentTypeDescriptionAtribute(){
        return match($this->payment_type){
            0 => "Paypal",
            1 => "MBWay",
            2 => "Visa",
            default => "None"
        }
    }*/
}
