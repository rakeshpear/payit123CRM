<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kycRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userName()
    {
        return $this->hasOne(Onboarding::class, 'id', 'clientId');
    }

    protected $table = 'kycrequests';
}

// RK