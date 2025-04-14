<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycEddQa extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'kyc_edd_qas';
}
