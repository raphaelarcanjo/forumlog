<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;

class BlogController extends Controller
{
    private $data;

    public function __construct()
    {
        $this->data = [
            'title' => 'Blog'
        ];
    }

    public function index(Request $request, $username = null)
    {
        $this->data['name'] = null;
        $perfil = null;

        if (Auth::check()) $perfil = Auth::user();
        else return view('blog.home', $this->data);

        if ($username) {
            $perfil = User::where([
                    ['username', $username],
                    ['is_active', 1]
                    ])
                ->first();
        }

        if ($perfil) {
            $blogs = Blog::withCount('comments')
                ->with('comments', 'comments.user')
                ->orderBy('blogs.id', 'desc')
                ->get();

            $this->data['blogs']     = $blogs;
            $this->data['fullname']  = $perfil['name'];
            $this->data['username']  = $perfil['username'];
            $this->data['id']        = $perfil['id'];
            $this->data['name']      = explode(' ',$perfil['name'])[0];
        } else {
            $request->session()->flash('error', 'Blog não encontrado.');
            return redirect()->route('home');
        }

        return view('blog.blog', $this->data);
    }

    public function create(Request $request)
    {
        if (!empty($request->only('message','private'))) {
            $valid = $request->validate([
                'message' => 'required|max:150'
            ]);

            $persist = User::find(Auth::id())->blog()->create([
                'message' => $request->input('message'),
                'private' => (bool) $request->input('private')
            ]);

            if ($persist) {
                $request->session()->flash('success','Post criado!');
                return redirect('blog/'.session('user'));
            } else $request->session()->flash('error','Não foi possível criar o post!');
        }

        $data['title'] = 'Blog';

        return view('blog.create', $this->data);
    }

    public function private(Request $request, $id)
    {
        $blog = Blog::find($id);
        $blog->update([ 'private' => ! $blog['private'] ]);
        $blog->comments()->delete();
        $request->session()->flash('success','Post atualizado!');

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        Blog::find($id)->delete();
        $request->session()->flash('success','Post excluído!');

        return redirect()->back();
    }

    public function createComment(Request $request)
    {
        $valid = $request->validate([
            'comment' => 'required|max:150',
        ]);

        $persist = User::find(Auth::user()->id)->blog_comment()->create([
            'message' => $request->input('comment'),
            'blog_id' => $request->input('blog_id')
        ]);

        if (! $persist) $request->session()->flash('error','Não foi possível criar o post!');

        return redirect()->back();
    }

    public function deleteComment(Request $request, $id)
    {
        BlogComment::find($id)->delete();
        $request->session()->flash('success','Comentário excluído!');

        return redirect()->back();
    }
}
