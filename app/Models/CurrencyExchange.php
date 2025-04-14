<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyExchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor',
        'bill_date',
        'bill',
        'due_date',
        'currency',
        'note',
    ];
}


