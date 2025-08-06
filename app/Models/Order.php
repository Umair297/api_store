<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'city',
        'country',
        'total_amount',
        'status',
    ];

    /**
     * Relationship: Order belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cast total_amount to float
     */
    protected $casts = [
        'total_amount' => 'float',
    ];
}
