<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\MessageBag;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\User;


class UserController extends Controller
{
    public function profile(Request $request, string $id)
    {
        $data['phones'] = ['','',''];
        $data['title'] = 'Perfil';
        $data['user'] = Auth::user();

        if ($id != Auth::id()) {
            $request->session()->flash('error','Não é possível visualizar ou alterar o perfil de outros usuários!');
            return redirect()->back();
        }

        if (!empty($request->all())) {
            $valid = $request->validate([
                'photo'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name'      => 'required|max:80',
                'email'     => 'required|email|max:80',
                'cep'       => 'required|max:9',
                'address'   => 'required|max:80',
                'complement'=> 'required|max:60',
                'suburb'    => 'required|max:80',
                'city'      => 'required|max:80',
                'state'     => 'required|max:80',
                'country'   => 'required|max:60',
            ]);

            $user               = new User();
            $user->idate        = $id;
            $user->name         = $request->input('name');
            $user->email        = strtolower($request->input('email'));
            $user->tagname      = strtolower($tagname);
            $user->phones       = json_encode($request->input('phones'));
            $user->cep          = (string)$request->input('cep');
            $user->address      = $request->input('address');
            $user->complement   = $request->input('complement');
            $user->suburb       = $request->input('suburb');
            $user->city         = $request->input('city');
            $user->state        = $request->input('state');
            $user->country      = $request->input('country');
            $user->birth        = $request->input('birth');

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photo_name = 'photo_'.$tagname.'.'.$photo->getClientOriginalExtension();

                $destination = public_path('users');

                $photo->move($destination, $photo_name);

                if (file_exists($destination.'/'.$photo_name)) $user->photo = $photo_name;
                else $request->session()->flash('error','Erro ao fazer upload da imagem!');
            }

            if ($user->update()) $request->session()->flash('success','Perfil atualizado com sucesso!');
            else $request->session()->flash('error','Erro ao tentar atualizar o seu cadastro!');
        }

        return view('profile', $data);
    }

    public function register(Request $request)
    {
        $data['title'] = 'Cadastro';
        $data['phones'] = ['','',''];

        if (Auth::check()) return redirect()->route('home');

        if (!empty($request->all()))
        {
            $data = $request->all();

            $valid = $request->validate([
                'name'      => 'required|max:80',
                'email'     => 'required|max:80',
                'tagname'   => 'required|unique:users|max:24',
                'cep'       => 'required|max:9',
                'address'   => 'required|max:80',
                'complement'=> 'max:60',
                'suburb'    => 'required|max:80',
                'city'      => 'required|max:80',
                'state'     => 'required|max:80',
                'country'   => 'required|max:60',
                'birth'     => 'required',
                'password'  => 'required|confirmed|min:8',
            ]);

            $user = new User();

            $user->name         = $request->input('name');
            $user->email        = strtolower($request->input('email'));
            $user->tagname      = strtolower($request->input('tagname'));
            $user->phones       = json_encode($request->input('phones'));
            $user->cep          = (string)$request->input('cep');
            $user->address      = $request->input('address');
            $user->complement   = $request->input('complement');
            $user->suburb       = $request->input('suburb');
            $user->city         = $request->input('city');
            $user->state        = $request->input('state');
            $user->country      = $request->input('country');
            $user->birth        = $request->input('birth');
            $user->ban          = 0;
            $user->password     = Hash::make($request->input('password'));

            if ($user->save()) {
                $request->session()->flash('success','Usuário cadastrado com sucesso!');
                return redirect()->route('home');
            }
            else {
                $request->session()->flash('error','Erro ao tentar cadastrar o usuário!');
            }
        }

        return view('register',$data);
    }

    public function recover(Request $request, $token = null)
    {
        $data['title'] = 'Recuperar Senha';

        if ($token)
        {
            $data['token'] = $token;

            return view('recover', $data);
        }

        if ($request->input('email')) {
            if ($request->input('password')) {

                $request->validate([
                    'token' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                ]);

                $status = Password::reset(
                    $request->only('email', 'password', 'password_confirmation', 'token'),
                    function ($user, $password) use ($request) {
                        $user->forceFill(['password' => Hash::make($password)])->save();
                        $user->setRememberToken(Str::random(60));

                        event(new PasswordReset($user));
                    }
                );

                if ($status == Password::PASSWORD_RESET) $request->session()->flash('success','Senha alterada com sucesso!');
                else $request->session()->flash('error','Não foi possível alterar as senhas!');
            } else {
                $request->validate(['email' => 'required|email']);

                $status = Password::sendResetLink($request->only('email'));

                if ($status == Password::RESET_LINK_SENT) $request->session()->flash('success','Foi enviado o link de redefinição de senha para o seu e-mail.');
                else  $request->session()->flash('error','E-mail não cadastrado em nossa base de dados.');
            }

            return redirect()->route('home');
        }

        return view('recover', $data);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember');

        if ($credentials)
        {
            $valid = $request->validate([
                'email'     => 'required|email',
                'password'  => 'required'
            ]);

            // dd($credentials);
            if (Auth::attempt($credentials, $remember)) $request->session()->regenerate();
            else $request->session()->flash('error', "Usuário ou senha inválido!");
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
