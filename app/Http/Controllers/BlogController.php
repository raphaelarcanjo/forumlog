<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Blog;

class BlogController extends Controller
{
    public function index(Request $request, $tagname = null)
    {
        $data['title'] = 'Blog';
        $data['name'] = null;

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
                    ->where([
                        ['created_by', '=', $tagname]
                    ])
                    ->orderBy('id', 'desc')
                    ->get();

                $data['name'] = explode(' ',$perfil['name'])[0];
            }

            return view('blog.blog', $data);
        }

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

                $data['name'] = explode(' ',$perfil['name'])[0];

                $posts = new Blog();
                $data['posts'] = $posts
                    ->where([
                        ['created_by', '=', session('user')]
                    ])
                    ->orderBy('id', 'desc')
                    ->get();

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
}
