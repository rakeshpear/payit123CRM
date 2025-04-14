<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'phone',
        'password',
        'avatar',
        'status',
        'marchant_id',
        'merchant_active',
        'customers',
        'commission_schedule',
        'commission',
        'payout',
        'amount_limit',
        'registered_by'
    ];

    public function Role(){
        return $this->hasOne(Role::class,'id','role');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clientDetails()
    {
        return $this->hasOne(ClientDetails::class, 'client_id', 'id');
    }
    
    public function clientSettlementLog()
    {
        return $this->hasOne(clientSettlementLog::class, 'user_ID', 'id');
    }

    public function Registered()
    {

        return $this->hasOne(User::class,'id','registered_by');
    }
}
