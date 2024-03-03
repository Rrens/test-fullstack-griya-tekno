<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoHouseCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'photo_house_customers';
    protected $fillable = [
        'customer_id',
        'photo_house',
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class,  'id', 'customer_id');
    }
}
