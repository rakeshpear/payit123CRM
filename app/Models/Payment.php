<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable=[
        'customer','amount','convert_amount','currency','crypto'
    ];

    public function Customer()
    {
        return $this->hasOne(User::class,'id','customer');
    }
}
