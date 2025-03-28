<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable=['emp_id','leave_type','application_start_date','application_end_date','reason','status','apply_day','approve_start_date','approve_end_date','approve_day','approve_by','application_hardcopy','emp_latitude','emp_longitude','emp_location'];


    public function userName()
    {
        return $this->hasOne(User::class,'id','emp_id');
    }

    public function LeaveType()
    {
        return $this->hasOne(LeaveType::class,'id','leave_type');
    }
}
