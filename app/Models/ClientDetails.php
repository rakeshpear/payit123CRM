<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDetails extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'agent_commission', 'client_commission', 'transaction_fee', 'crypto_fee', 'chargeback_fee', 'refund_fee', 'highRisk_fee', 'fraudWarning_fee', 'currency', 'rolling_reserve', 'payment_gateway_id', 'amount_limit', 'card_limit', 'psp', 'agents', 'payit123share', 'extra_client_fee', 'before_rolling_reserve', 'payabletoclient', 'net_after_psp_client'];
}
