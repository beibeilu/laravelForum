<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ["body", "thread_id", "user_id", "updated_at", "created_at"];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
