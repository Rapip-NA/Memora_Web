<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $q = $request->input('q');
        
        $users = collect();
        $posts = collect();
        
        if ($q) {
            $users = User::where('name', 'like', "%$q%")->orWhere('bio', 'like', "%$q%")->get();
            $posts = Post::where('content', 'like', "%$q%")
                ->with(['user', 'comments.user', 'likes', 'bookmarks', 'poll.options', 'poll.votes'])
                ->latest()
                ->paginate(20);
        } else {
            $posts = Post::with(['user', 'comments.user', 'likes', 'bookmarks', 'poll.options', 'poll.votes'])
                ->latest()
                ->paginate(20);
        }
        
        return view('desktop.explore', compact('currentUser', 'users', 'posts', 'q'));
    }
}
