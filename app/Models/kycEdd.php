<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kycEdd extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kycDetail()
    {
        return $this->hasOne(kycRequest::class, 'id', 'kyc_ID');
    }

    public function onboardDetail()
    {
        return $this->hasOne(Onboarding::class, 'id', 'onboarding_ID');
    }

    protected $table = 'kyc_edd';
}
