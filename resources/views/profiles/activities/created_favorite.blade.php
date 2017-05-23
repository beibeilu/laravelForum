@component('profiles.activities._activities')
    @slot('heading')
        {{ $profileUser->name }} favorited <a href="/profiles/{{ $activity->subject->favorited->owner->name }}">{{ $activity->subject->favorited->owner->name }}</a>'s reply to
        <a href="{{ $activity->subject->favorited->thread->showThreadPath() }}">{{ $activity->subject->favorited->thread->title }}</a> {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        <a href="{{ $activity->subject->favorited->showReplyPath() }}">View Reply</a>
        <blockquote>{{ $activity->subject->favorited->body }}</blockquote>
    @endslot
@endcomponent