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
                                <div class="level">
                                    <h4 class="flex"><a href="{{$thread->showThreadPath()}}">{{ $thread->title }}</a></h4>

                                    <a href="{{ $thread->showThreadPath() }}">
                                        <strong>{{ $thread->replies_count }}&nbsp;</strong> {{ str_plural('reply', $thread->replies_count) }}
                                    </a>
                                </div>

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
