<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            $user->email      = strtolower($request->input('email'));
            $user->tagname    = strtolower($request->input('tagname'));
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

            if ($user->save()) {
                $request->session()->flash('success','Usuário cadastrado com sucesso!');
                return redirect('forumlog');
            }
            else {
                $request->session()->flash('error','Erro ao tentar cadastrar o usuário!');
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
                ['tagname', '=', strtolower($request->input('login'))],
                ['ban', '=', 0]
                ])
                ->first();
                
            if ($login) {
                if ($login['password'] === md5($request->input('password'))) {
                    $request->session()->put('token', md5(strtolower($request->input('login')).'teste123'));
                    $request->session()->put('user', strtolower($request->input('login')));
                    
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
        
        return redirect('forumlog');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('forumlog');
    }

    public function recover(Request $request, $token = null)
    {
        $data['title'] = 'Recuperar Senha';
        $data['valid'] = false;
        
        $email = $request->input('email');
        
        if ($email)
        {
            $user = new UserModel;
    
            $recoverUser = $user->where('email',$email)->first();

            if ($recoverUser)
            {
                $to_name = $recoverUser['name'];
                $to_address = $email;
                $from_name = config('app.name');
                $body = "Recuperação de Senha | ForumLog";
                $link = url('user/recover').'/'.md5($email.date('Y-m-d'));

                $msgData = ['name' => $to_name, 'body' => $body, 'link' => $link];

                Mail::send('email', $msgData, function($message) use ($request, $to_name, $to_address) {
                    $message->to($to_address, $to_name)->subject('Recuperação de Senha | ForumLog');

                    $request->session()->flash('success','Foi enviado o link de redefinição de senha para o seu e-mail.');
                    
                    return redirect('forumlog');
                });
            } else {
                $request->session()->flash('error','E-mail não cadastrado em nossa base de dados.');
                return redirect('forumlog');
            }
        }

        if ($token)
        {
            $user = new UserModel;

            $users = $user->get();
    
            foreach ($users as $theUser)
            {
                if ($token == md5($theUser['email'].date('Y-m-d')))
                {
                    $data['valid'] = true;
                    $data['user'] = $theUser['email'];
                }
            }
        }

        if ($request->input('recover'))
        {
            $user = new UserModel;
            $save = [
                'password' => $request->input('password')
            ];
            
            $user->where($request->input('email'))->save($save);
        }

        return view('recover', $data);
    }
}
