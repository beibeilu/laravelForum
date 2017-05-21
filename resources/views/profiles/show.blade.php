@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="page-header">
                <h1>{{ $profileUser->name }}</h1>
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </div>

            @forelse($threads as $thread)
            <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="level">
                            <h4 class="flex"><a href="{{ $thread->showThreadPath() }}">{{ $thread->title }}</a></h4>
                            <span>Published {{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                        <div>
                            {{ $thread->body }}
                        </div>
                    </div>

            </div>
            @empty
                <h4>You do not have any threads.</h4>
            @endforelse
            {{ $threads->links() }}

        </div>
    </div>
</div>
@endsection