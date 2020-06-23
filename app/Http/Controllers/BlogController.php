<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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

                return view('blog.blog', $data);
            }
        }

        return view('blog.home', $data);
    }
}
