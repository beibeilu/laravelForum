@component('profiles.activities._activities')
    @slot('heading')
        {{ $profileUser->name }} published <a href="{{$activity->subject->showThreadPath()}}">{{ $activity->subject->title }}</a> {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        <h4>
            <a href="{{$activity->subject->showThreadPath()}}">{{ $activity->subject->title }}</a>
        </h4>
        <div>
            {{ $activity->subject->body }}
        </div>
    @endslot
@endcomponent