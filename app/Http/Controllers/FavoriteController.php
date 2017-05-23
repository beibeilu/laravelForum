<?php

namespace App\Http\Controllers;
use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorited();
        return back();  // TODO: For users who redirect back from successful login, this does not redirect back to the thread correctly.
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
