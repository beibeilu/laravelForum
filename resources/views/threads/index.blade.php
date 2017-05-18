@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                        @foreach($threads as $thread)
                            <article>
                                <a href="{{$thread->showThreadPath()}}">
                                    <h4>{{ $thread->title }}</h4>
                                </a>
                                <p>{{ $thread->body }}</p>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
