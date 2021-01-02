<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Blog;
use App\Comments;

class BlogController extends Controller
{
    public function index(Request $request, $tagname = null)
    {
        $data['title'] = 'Blog';
        $data['name'] = null;
        $perfil = null;

        if (Auth::check()) $perfil = Auth::user();
        else {
            $request->session()->flash('error','É necessário estar logado para acessar essa página!');
            return redirect()->route('home');
        }

        if ($tagname) {
            $perfil = User::where([
                    ['tagname', '=', $tagname],
                    ['ban', '=', 0]
                    ])
                ->first();
        }

        if ($perfil)
        {
            $posts = Blog::selectRaw('count(blog_comments.id) as comments_count, blog.*')
                ->leftJoin('blog_comments','blog_comments.post','=','blog.id')
                ->where('blog.created_by', '=', $perfil->id)
                ->orderBy('blog.id', 'desc')
                ->groupBy('blog.id')
                ->get();

            foreach ($posts as &$post) {
                $post->comments = Comments::where('post', '=', $post->id)
                    ->orderBy('updated_at')
                    ->get();
            }

            $data['posts']      = $posts;
            $data['fullname']   = $perfil['name'];
            $data['tagname']    = $perfil['tagname'];
            $data['name']       = explode(' ',$perfil['name'])[0];
        }
        else $request->session()->flash('error', 'Usuário não encontrado.');

        return view('blog.blog', $data);
    }

    public function createpost(Request $request)
    {
        $data['title'] = 'Blog';

        if (!empty($request->only('message','private'))) {
            $valid = $request->validate([
                'message' => 'required|max:150'
            ]);

            $post = new Blog();

            $post['message']    = $request->input('message');
            $post['private']    = (bool) $request->input('private');
            $post['created_by'] = Auth::id();

            if ($post->save()) {
                $request->session()->flash('success','Post criado!');
                return redirect('blog/'.session('user'));
            }
            else {
                $request->session()->flash('error','Não foi possível criar o post!');
            }
        }

        return view('blog.create', $data);
    }

    public function privatepost(Request $request, $id)
    {
        if (Auth::check()) {
            $state = Blog::where('id', '=', $id)->first();

            if ($state->private == 1) {
                $state->private = 0;
            } else {
                $state->private = 1;
            }

            $comment = new Comments();

            $comment->where('post', '=', $id)->delete();

            if ($state->update()) {
                $request->session()->flash('success','Post atualizado!');
            }
        }

        return redirect()->back();
    }

    public function deletepost(Request $request, $id)
    {
        if (Auth::check()) {
            Blog::where('id', '=', $id)->delete();
            $request->session()->flash('success','Post excluído!');
        }

        return redirect()->back();
    }

    public function createcomment(Request $request)
    {
        if (Auth::check()) {
            $valid = $request->validate([
                'comment' => 'required|max:150',
            ]);

            $comment = new Comments();

            $comment['comment'] = $request->input('comment');
            $comment['post'] = $request->input('post_id');
            $comment['comment_by'] = Auth::user()->tagname;
            $comment->save();
        }

        return redirect()->back();
    }

    public function deletecomment(Request $request, $id)
    {
        if (Auth::check()) {
            Comments::where('id', '=', $id)->delete();
            $request->session()->flash('success','Comentário excluído!');
        }

        return redirect()->back();
    }
}
