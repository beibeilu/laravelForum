@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse($threads as $thread)
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex"><a href="{{$thread->showThreadPath()}}">{{ $thread->title }}</a></h4>

                                <a href="{{ $thread->showThreadPath() }}">
                                    <strong>{{ $thread->replies_count }}&nbsp;</strong> {{ str_plural('reply', $thread->replies_count) }}
                                </a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <p>{{ $thread->body }}</p>
                        </div>
                    </div>
                @empty
                    <h4>There are no relevant result this time.</h4>
                @endforelse
            </div>
        </div>
    </div>
@endsection
