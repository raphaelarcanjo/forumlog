<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserModel;

class User extends Controller
{
    public function profile(int $id)
    {
        return view('profile',['title' => 'Perfil']);
    }

    public function forum()
    {
        return view('forum.home', ['title' => 'Forum']);
    }

    public function blog(Request $request, $tagname = null)
    {
        $data['title'] = 'Blog';
            
        if ($tagname) {
            $user = new UserModel();
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

    public function register(Request $request)
    {
        if (!empty($request->all()))
        {
            $data = $request->all();

            $valid = $request->validate([
                'name'      => 'required|max:80',
                'email'     => 'required|unique:users|max:80',
                'tagname'   => 'required|unique:users|max:24',
                'cep'       => 'required|max:8',
                'address'   => 'required|max:80',
                'complement'=> 'max:60',
                'suburb'    => 'required|max:80',
                'city'      => 'required|max:80',
                'state'     => 'required|max:80',
                'country'   => 'required|max:60',
                'birth'     => 'required|date',
                'password'  => 'required|min:8',
                'confirm'   => ($request->input('password') != $request->input('confirm')) ? 'max:1' : ''
            ]);
            
            $user = new UserModel();
            
            $user->name       = $request->input('name');
            $user->email      = lcfirst($request->input('email'));
            $user->tagname    = lcfirst($request->input('tagname'));
            $user->phone      = json_encode($request->input('phone'));
            $user->cep        = (string)$request->input('cep');
            $user->address    = $request->input('address');
            $user->complement = $request->input('complement');
            $user->suburb     = $request->input('suburb');
            $user->city       = $request->input('city');
            $user->state      = $request->input('state');
            $user->country    = $request->input('country');
            $user->birth      = $request->input('birth');
            $user->password   = md5($request->input('password'));

            if ($user->save()) return redirect('forumlog');
            else {
                $request->session()->put('error','Erro ao tentar cadastrar o usuário!');
                return redirect('forumlog');
            }
        }

        $data['title'] = 'Cadastro';

        return view('register',$data);
    }

    public function login(Request $request)
    {
        if (!empty($request->all()))
        {
            $valid = $request->validate([
                'login'     => 'required',
                'password'  => 'required'
            ]);
            
            $user = new UserModel;
            $login = $user
            ->where([
                ['tagname', '=', $request->input('login')],
                ['ban', '=', 0]
                ])
                ->first();
                
            if ($login) {
                if ($login['password'] === md5($request->input('password'))) {
                    $request->session()->put('token', md5($request->input('login').'teste123'));
                    $request->session()->put('user', $request->input('login'));
                    
                    return redirect('forumlog/user/blog/'.$login['tagname']);
                } else {
                    $request->session()->flash('error', "A senha informada está incorreta!");
                    return redirect('forumlog');
                }
            } else {
                $request->session()->flash('error', "Usuário não cadastrado ou banido!");
                return redirect('forumlog');
            }
        }
        
        return redirect('home');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('forumlog');
    }

    public function recover()
    {
        return redirect('home');
    }
}
