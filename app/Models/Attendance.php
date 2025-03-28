<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable=['emp_id','date','time_in','in_location','in_latitude','in_longitude','time_out','out_location','out_latitude','out_longitude','time_status'];


    public function userName()
    {
        return $this->hasOne(User::class,'id','emp_id');
    }

}
