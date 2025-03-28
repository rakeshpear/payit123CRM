<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyReports extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'weekly_reports';
    
    public function clientDetails()
    {
        return $this->hasOne(ClientDetails::class, 'client_id', 'user_ID');
    }
}
