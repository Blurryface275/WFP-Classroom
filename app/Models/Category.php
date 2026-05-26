<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'image'];

    public function services()
    {
        // category_id -> foreign key in services table
        // id -> primary key in categories table
        return $this->hasMany(Service::class, 'category_id', 'id');
    }
}
