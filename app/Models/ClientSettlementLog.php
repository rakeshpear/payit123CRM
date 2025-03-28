<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSettlementLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "clientsettlementlog";
}
