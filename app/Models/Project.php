<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'deadline',
        'status',
        'multi_ids',
        'team_ids',
        'mark_done',
    ];


    public function users(){
        return $this->hasMany(User::class,'id','team_ids');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class,'project_id','id');
    }
}
