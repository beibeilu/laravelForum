@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>{{ $thread->title }}</h3>
                        <a href="#">{{ $thread->creator->name }}</a> created
                        {{ $thread->created_at->diffForHumans() }}
                    </div>

                    <div class="panel-body">
                        <article>
                            {{ $thread->body }}
                        </article>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(auth()->check())
                    <div style="height: 250px;">
                        <h3>Reply</h3>
                        <form method="POST" action="{{ $thread->showThreadPath(). '/replies' }}">
                            {{ csrf_field() }}
                            <textarea name="body" id="body" rows="2" class="form-control" placeholder="Have something to say..."></textarea>
                            <br>
                            <button class="btn btn-default">Reply</button>
                        </form>
                    </div>
                @else
                    <div style="height:100px">
                        <h4 align="center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</h4>
                    </div>
                @endif
            </div>
        </div>


    </div>


@endsection
