<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">

                <div class="flex">
                <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}
                </div>

                @if(auth()->check())
                <div>
                    <favorite :reply="{{ $reply }}"></favorite>
                </div>
                @endif
            </div>

        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-primary btn-xs mr-1" @click="update">Update</button>
                <button class="btn btn-default btn-xs mr-1" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>
        @can('update', $reply)
        <div class="panel-footer level">
            <button class="btn btn-toolbar btn-xs mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
        </div>
        @endcan
    </div>
</reply>