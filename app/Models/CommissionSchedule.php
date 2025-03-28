<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionSchedule extends Model
{
    use HasFactory;

    protected $fillable=['type','rate','volume_from','volume_to'];
}
