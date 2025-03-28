<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function countrie_info(){
        return $this->hasOne(Countrie::class,'id','country');
    }

    public function currency_info(){
        return $this->hasOne(Currencies::class,'id','currency');
    }
}
