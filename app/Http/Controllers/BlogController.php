<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;

class BlogController extends Controller
{
    public function index(Request $request, $username = null)
    {
        $data['title'] = 'Blog';
        $data['name'] = null;
        $perfil = null;

        if (Auth::check()) $perfil = Auth::user();
        else return view('blog.home', $data);

        if ($username) {
            $perfil = User::where([
                    ['username', $username],
                    ['is_active', 1]
                    ])
                ->first();
        }

        if ($perfil)
        {
            $blogs = Blog::withCount('comments')
                ->with('comments', 'comments.user')
                ->orderBy('blogs.id', 'desc')
                ->get();

            $data['blogs']     = $blogs;
            $data['fullname']  = $perfil['name'];
            $data['username']  = $perfil['username'];
            $data['id']        = $perfil['id'];
            $data['name']      = explode(' ',$perfil['name'])[0];
        }
        else {
            $request->session()->flash('error', 'Blog não encontrado.');
            return redirect()->route('home');
        }

        return view('blog.blog', $data);
    }

    public function create(Request $request)
    {
        if (!empty($request->only('message','private'))) {
            $valid = $request->validate([
                'message' => 'required|max:150'
            ]);

            $blog = new Blog();

            $blog['message']    = $request->input('message');
            $blog['private']    = (bool) $request->input('private');
            $blog['user_id'] = Auth::id();

            if ($blog->save()) {
                $request->session()->flash('success','Post criado!');
                return redirect('blog/'.session('user'));
            }
            else $request->session()->flash('error','Não foi possível criar o post!');
        }

        $data['title'] = 'Blog';

        return view('blog.create', $data);
    }

    public function private(Request $request, $id)
    {
        $state = Blog::where('id', $id)->first();
        $state->private = ! $state->private;

        if ($state->update()) {
            BlogComment::where('blog_id', $id)->delete();
            $request->session()->flash('success','Post atualizado!');
        }

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        Blog::where('id', $id)->delete();
        $request->session()->flash('success','Post excluído!');

        return redirect()->back();
    }

    public function createComment(Request $request)
    {
        $valid = $request->validate([
            'comment' => 'required|max:150',
        ]);

        $comment = new BlogComment();

        $comment['message'] = $request->input('comment');
        $comment['blog_id'] = $request->input('blog_id');
        $comment['user_id'] = Auth::user()->id;
        $comment->save();

        return redirect()->back();
    }

    public function deleteComment(Request $request, $id)
    {
        BlogComment::where('id', $id)->delete();
        $request->session()->flash('success','Comentário excluído!');

        return redirect()->back();
    }
}
