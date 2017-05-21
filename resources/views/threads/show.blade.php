@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>{{ $thread->title }}</h3>
                        <a href="/profiles/{{$thread->creator->name}}">{{ $thread->creator->name }}</a> created
                        {{ $thread->created_at->diffForHumans() }}
                    </div>

                    <div class="panel-body">
                        <article>
                            {{ $thread->body }}
                        </article>
                    </div>
                </div>
                <hr>

                {{--Replies--}}
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

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

            {{--Sidebar--}}
            <div class="col-md-4">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
