<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 'start_time', 'end_time', 'total_hours','date',
   ];

   public function User(){
        return $this->hasOne(User::class,'id','user_id');
    }

    
}
