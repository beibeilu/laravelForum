<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['type', 'user_id', 'subject_id', 'subject_type', 'created_at'];

    public function subject(){
        return $this->morphTo();
    }

    public static function feed(User $user, $take = 50){
        return static::where('user_id', $user->id)
            ->with('subject')
            ->take($take)
            ->latest()
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            }); //50 most recent, activities - group by day - activities
    }
}
