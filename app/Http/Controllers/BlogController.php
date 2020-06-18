<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($tagname = null)
    {
        if (session('user') && session('token'))
        {
            if (session('token') == md5(session('user').'teste123'))
            {
                return redirect('forumlog/user/blog/'.session('user'));
            }
        }

        if ($tagname) return redirect('/forumlog/user/blog/'.$tagname);
        
        return view('blog.home', ['title' => 'Blog']);
    }

    public function blog(Request $request, $tagname = null)
    {
        $data['title'] = 'Blog';
            
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
                $data['name'] = explode(' ',$perfil['name'])[0];
            }
        }

        return view('blog.blog', $data);
    }
}
