<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\Comments;

class BlogController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $data['title'] = 'Blog';
        $data['name'] = null;
        $perfil = null;

        if (Auth::check()) $perfil = Auth::user();
        else return view('blog.home', $data);

        if ($id) {
            $perfil = User::where([
                    ['id', '=', $id],
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
            $data['id']         = $id;
            $data['name']       = explode(' ',$perfil['name'])[0];
        }
        else {
            $request->session()->flash('error', 'Blog não encontrado.');
            return redirect()->route('home');
        }

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
            else $request->session()->flash('error','Não foi possível criar o post!');
        }

        return view('blog.create', $data);
    }

    public function privatepost(Request $request, $id)
    {
        $state = Blog::where('id', '=', $id)->first();
        $state->private = ! $state->private;

        if ($state->update()) {
            Comments::where('post', '=', $id)->delete();
            $request->session()->flash('success','Post atualizado!');
        }

        return redirect()->back();
    }

    public function deletepost(Request $request, $id)
    {
        Blog::where('id', '=', $id)->delete();
        $request->session()->flash('success','Post excluído!');

        return redirect()->back();
    }

    public function createcomment(Request $request)
    {
        $valid = $request->validate([
            'comment' => 'required|max:150',
        ]);

        $comment = new Comments();

        $comment['comment'] = $request->input('comment');
        $comment['post'] = $request->input('post_id');
        $comment['comment_by'] = Auth::user()->tagname;
        $comment->save();

        return redirect()->back();
    }

    public function deletecomment(Request $request, $id)
    {
        Comments::where('id', '=', $id)->delete();
        $request->session()->flash('success','Comentário excluído!');

        return redirect()->back();
    }
}
