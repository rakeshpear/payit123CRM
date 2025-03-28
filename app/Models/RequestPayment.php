<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer(){
        return $this->hasOne(User::class,'id','customer_id');
    }

    public function customerPayment(){
        return $this->hasOne(CustomerPayment::class,'id','customer_payment_id');
    }
}
