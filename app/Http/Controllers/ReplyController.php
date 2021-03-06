<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;
use App\Thread;
class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channel_id, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->expectsJson()){
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }
}
