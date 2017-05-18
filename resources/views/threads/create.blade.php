@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a new thread</div>

                    <div class="panel-body">
                        <form action="/threads" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input name="title" type="text" class="form-control" id="title" placeholder="title">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control" placeholder="Start writing here"></textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection