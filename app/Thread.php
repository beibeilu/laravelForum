<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $fillable = ['title', 'body', 'user_id', 'channel_id'];
    protected $with = ['creator', 'channel'];        //.. Or add global scope below

    protected static function boot(){
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder){
            $builder->withCount('replies');
        });

//        static::addGlobalScope('creator', function ($builder){
//            $builder->with('creator');
//        });

        static::deleting(function($thread){
            $thread->replies->each->delete();   //higher order messaging on laravel collection.
//            $thread->replies->each(function($reply){
//                $reply->delete();
//            });
        });
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(){
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function addReply($reply){   // Could pass in ($reply) as an array or could be (Reply $reply) as Reply
        $this->replies()->create($reply);   // Will automatically set thread_id.
    }

    public function showThreadPath()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }
}
