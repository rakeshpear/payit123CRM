<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

     protected $fillable = [

        'user_id',
        'task_id',
        'comments',
        'document'
    ];

   public function Cmt_User_Name()
   {
      return $this->hasOne(User::class,'id','user_id');
   }


   public function Tsk_Name()
   {
      return $this->hasOne(Task::class,'id','task_id');
   }
}
