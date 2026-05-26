<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_date',
        'status',
        'total_price',
        'payment_method',
    ];

    // Many-to-Many: Transaction dapat memiliki banyak Service
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_transaction', 'transaction_id', 'service_id');
    }
}
