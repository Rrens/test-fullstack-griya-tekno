<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $tables = 'customers';
    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'photo_ktp',
    ];

    public function image_house()
    {
        return $this->belongsTo(PhotoHouseCustomer::class);
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }
}
