<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'created_at', 'updated_at'];

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply){   // Could pass in ($reply) as an array or could be (Reply $reply) as Reply
        $this->replies()->create($reply);   // Will automatically set thread_id.
    }
}
