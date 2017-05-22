<?php

namespace App;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach (static::getRecordedEvents() as $recordedEvent) {
            static::$recordedEvent(function($model) use ($recordedEvent) {
                $model->recordActivity($recordedEvent);
            });
        }

        static::deleting(function($model) {
            $model->activity()->delete();
        });
    }

    protected static function getRecordedEvents() {
        return ['created', 'updated', ];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    public function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }
}