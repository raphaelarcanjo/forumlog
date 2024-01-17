<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Forum;
use App\Models\ForumComment;

class ForumController extends Controller
{
    private $data;

    public function __construct()
    {
        $this->data = [
            'title' => 'Forum'
        ];
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $this->data['topics'] = Forum::withCount('comments')
                ->with('user')
                ->with('comments', 'comments.user')
                ->orderBy('forums.id', 'desc')
                ->get();
            return view('forum.page', $this->data);
        }
        
        return view('forum.home', $this->data);
    }

    public function create(Request $request)
    {
        if (!empty($request->only('title', 'message','private'))) {
            $valid = $request->validate([
                'message' => 'required|max:150'
            ]);

            $forum = new Forum();

            $forum['title']         = $request->input('title');
            $forum['message']       = $request->input('message');
            $forum['private']       = (bool) $request->input('private');
            $forum['user_id']       = Auth::id();

            if ($forum->save()) {
                $request->session()->flash('success','Tópico criado!');
                return redirect('forum/'.session('user'));
            }
            else $request->session()->flash('error','Não foi possível criar o tópico!');
        }

        return view('forum.create', $this->data);
    }

    public function topic($id)
    {
        $forum = Forum::with('user')
            ->with('comments', 'comments.user')
            ->find($id);
        
        $this->data = [
            'forum' => $forum
        ];

        return view('forum.topic', $this->data);
    }

    public function comment(Request $request, $id)
    {
        $comment = new ForumComment();

        $comment['message'] = $request->input('message');
        $comment['forum_id'] = $id;
        $comment['user_id'] = Auth::id();
        
        if (!$comment->save()) $request->session()->flash('error','Não foi possível criar o comentário!');
        
        return redirect('forum/'.$id);
    }
}
