<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'description',
        'availability',
        'price',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Many-to-Many: Service dapat dimiliki banyak Transaction
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'service_transaction', 'service_id', 'transaction_id');
    }
}
