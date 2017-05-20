<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">

            <div class="flex">
            <a href="#">{{ $reply->owner->name }}</a> said
            {{ $reply->created_at->diffForHumans() }}
            </div>

            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->getFavoritesCount() }} &nbsp; {{ str_plural('Favorite', $reply->getFavoritesCount()) }}
                    </button>
                </form>
            </div>

        </div>

    </div>
    <div class="panel-body">
        <article>
            <p>{{ $reply->body }}</p>
        </article>
    </div>
</div>