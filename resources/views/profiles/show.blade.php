@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="page-header">
                <h1>{{ $profileUser->name }}</h1>
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </div>

            @forelse($activities as $date => $activitiesOnDate)
                <h3 class="page-header">{{ $date }}</h3>
                @foreach($activitiesOnDate as $activity)
                    @include ("profiles.activities.{$activity->type}")
                @endforeach
            @empty
                <h4>You do not have any activity.</h4>
            @endforelse
            {{--{{ $threads->links() }}--}}

        </div>
    </div>
</div>
@endsection




