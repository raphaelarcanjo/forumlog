<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;

class BlogController extends Controller
{
    public function index(Request $request, $tagname = null)
    {
        $data['title'] = 'Blog';
        $data['name'] = null;

        // BY TAGNAME
        if ($tagname) {
            $user = new User();
            $perfil = $user
                ->where([
                    ['tagname', '=', $tagname],
                    ['ban', '=', 0]
                    ])
                ->first();

            if (!empty($perfil))
            {
                $posts = new Blog();
                $data['posts'] = $posts
                    ->where('created_by', '=', $tagname)
                    ->orderBy('id', 'desc')
                    ->get();

                $comments = array();
                
                foreach ($data['posts'] as $post) {
                    $comment = new Comments();

                    $post_comments = $comment
                        ->where('post', '=',  $post->id)
                        ->get();
                    
                    $comments[$post->id] = $post_comments;
                }

                $data['comments']   = $comments;
                $data['fullname']   = $perfil['name'];
                $data['tagname']    = $perfil['tagname'];
                $data['name']       = explode(' ',$perfil['name'])[0];
            }

            return view('blog.blog', $data);
        }

        // BY SESSION IF LOGGED
        if (session('user') && session('token'))
        {
            if (session('token') == md5(session('user').'teste123'))
            {
                $user = new User();
                $perfil = $user
                    ->where([
                        ['tagname', '=', session('user')],
                        ['ban', '=', 0]
                        ])
                    ->first();
                    
                $posts = new Blog();
                $data['posts'] = $posts
                ->where('created_by', '=', session('user'))
                ->orderBy('id', 'desc')
                ->get();
                
                $comments = array();

                foreach ($data['posts'] as $post) {
                    $comment = new Comments();
                    
                    $post_comments = $comment
                    ->where('post', '=',  $post->id)
                    ->get();
                    
                    $comments[$post->id] = $post_comments;
                }
                
                $data['comments']   = $comments;
                $data['fullname']   = $perfil['name'];
                $data['tagname']    = $perfil['tagname'];
                $data['name']       = explode(' ',$perfil['name'])[0];

                return view('blog.blog', $data);
            }
        }

        return view('blog.home', $data);
    }

    public function createpost(Request $request)
    {
        $data['title'] = 'Blog';

        if (!empty($request->all())) {
            $valid = $request->validate([
                'message' => 'required|max:150'
            ]);
    
            $post = new Blog();
    
            $post['message']    = $request->input('message');
            $post['private']    = $request->input('private');
            $post['created_by'] = session('user');
    
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
        if (session('user') && session('token')) {
            if (md5(session('user').'teste123') === session('token')) {
                $post = new Blog();
        
                $state = $post->where('id', '=', $id)->first();
        
                if ($state->private == 1) {
                    $state->private = null;
                } else {
                    $state->private = 1;
                }
    
                $comment = new Comments();
        
                $comment->where('post', '=', $id)->delete();
    
                if ($state->update()) {
                    $request->session()->flash('success','Post atualizado!');
                }
        
            } else {
                $request->session()->flash('error','Só é possível executar essa ação logado!');
            }
        }

        return redirect()->back();
    }

    public function deletepost(Request $request, $id)
    {
        if (session('user') && session('token')) {
            if (md5(session('user').'teste123') === session('token')) {
                $post = new Blog();
        
                $post->where('id', '=', $id)->delete();
        
                $request->session()->flash('success','Post excluído!');
            } else {
                $request->session()->flash('error','Só é possível executar essa ação logado!');
            }
        }

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
        $comment['comment_by'] = $request->input('comment_by');

        $comment->save();
        $blog = new Blog();

        $tagname = $blog
            ->where('id', '=', $request->input('post_id'))
            ->first('created_by');

        return redirect('blog/'.$tagname->created_by);
    }

    public function deletecomment(Request $request, $id)
    {
        if (session('user') && session('token')) {
            if (md5(session('user').'teste123') === session('token')) {

                $comment = new Comments();
        
                $comment->where('id', '=', $id)->delete();
        
                $request->session()->flash('success','Comentário excluído!');
            } else {
                $request->session()->flash('error','Só é possível executar essa ação logado!');
            }
        }

        return redirect()->back();
    }
}
