<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

     protected $fillable = [
        'project_id',
        'title',
        'start_date',
        'end_date',
        'assign_to',
        'mark_done',
        'cost',
        'currency'
    ];

    // public function User()
    // {
    //     return $this->hasOne(User::class, 'id', 'assign_to');
    // }

   public function TaskComment()
   {
      return $this->hasMany(Comment::class,'task_id','id');
   } 

   public function TaskHours()
   {
      return $this->hasMany(TaskWorkingHours::class,'task_id','id');
   }

    
}
