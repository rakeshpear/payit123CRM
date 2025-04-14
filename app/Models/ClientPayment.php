<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function client(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function payment(){
        return $this->hasOne(PaymentMethod::class,'id','payment_moad_id');
    }
}
