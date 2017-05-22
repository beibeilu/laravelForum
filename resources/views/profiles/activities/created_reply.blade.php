@component('profiles.activities._activities')
    @slot('heading')
        {{ $profileUser->name }} replied to thread <a href="{{$activity->subject->thread->showThreadPath()}}">{{ $activity->subject->thread->title }}</a> {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        <blockquote>{{ $activity->subject->body }}</blockquote>
    @endslot
@endcomponent