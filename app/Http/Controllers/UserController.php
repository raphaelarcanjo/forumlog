<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Phone;
use App\Models\Address;


class UserController extends Controller
{
    public function profile(Request $request)
    {
        if (!empty($request->all())) {
            $valid = $request->validate([
                'photo'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name'      => 'required|max:80',
                'email'     => 'required|email|max:80',
                'cep'       => 'required|max:9',
                'address'   => 'required|max:120',
                'complement'=> 'required|max:60',
                'suburb'    => 'required|max:60',
                'city'      => 'required|max:60',
                'province'  => 'required|max:60',
                'country'   => 'required|max:60',
            ]);

            try {
                DB::beginTransaction();

                $user                   = User::find(Auth::id());

                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo');
                    $photo_name = 'photo_'.$user->username.'.'.$photo->getClientOriginalExtension();
    
                    $destination = public_path('users');
    
                    $photo->move($destination, $photo_name);
    
                    if (file_exists($destination.'/'.$photo_name)) $user->photo = $photo_name;
                    else $request->session()->flash('error','Erro ao fazer upload da imagem!');
                }

                $user->name             = $request->input('name');
                $user->email            = strtolower($request->input('email'));
                $user->username         = strtolower($request->input('username'));
                $user->birth            = date('Y-m-d', strtotime(str_replace('/','-',$request->input('birth'))));
                $user->password         = Hash::make($request->input('password'));
                $user->save();
    
                $address                = Address::where('user_id', Auth::id())->first();
                $address->cep           = (string) preg_replace('/[^0-9]/', '', $request->input('cep'));
                $address->address       = $request->input('address');
                $address->complement    = $request->input('complement');
                $address->suburb        = $request->input('suburb');
                $address->city          = $request->input('city');
                $address->province      = $request->input('province');
                $address->country       = $request->input('country');
                $address->save();
                
                Phone::where('user_id', Auth::id())->delete();

                foreach ($request->input('phones') as $number) {
                    if (empty($number)) continue;
                    $phone              = new Phone();
                    $phone->user_id     = Auth::id();
                    $phone->number      = (string) preg_replace('/[^0-9]/', '', $number);
                    $phone->save();
                }

                DB::commit();

                $request->session()->flash('success','Perfil atualizado com sucesso!');
            } catch (\Throwable $th) {
                DB::rollBack();

                $request->session()->flash('error', 'Erro ao tentar atualizar o seu cadastro! -> '.$th->getMessage());
            }
        }

        $user = User::find(Auth::id());
        $user->phones = $user->phone()->get();
        $user->address = $user->address()->first();
        $user->birth = date('d/m/Y', strtotime($user->birth));
        $data = [
            'user' => $user,
            'title' => 'Perfil',
        ];

        return view('profile', $data);
    }

    public function register(Request $request)
    {
        if (Auth::check()) return redirect()->route('home');

        if (!empty($request->all()))
        {
            $data = $request->all();

            $valid = $request->validate([
                'name'      => 'required|max:80',
                'email'     => 'required|max:80',
                'username'   => 'required|unique:users|max:32',
                'birth'     => 'required',
                'password'  => 'required|confirmed|min:8',
                'cep'       => 'required|max:9',
                'address'   => 'required|max:120',
                'complement'=> 'max:80',
                'suburb'    => 'required|max:60',
                'city'      => 'required|max:60',
                'province'     => 'required|max:60',
                'country'   => 'required|max:60',
            ]);

            try {
                DB::beginTransaction();

                $user = new User();
                $user->name         = $request->input('name');
                $user->email        = strtolower($request->input('email'));
                $user->username     = strtolower($request->input('username'));
                $user->birth        = date('Y-m-d', strtotime(str_replace('/','-',$request->input('birth'))));
                $user->password     = Hash::make($request->input('password'));
                $user->save();
    
                $address = new Address();
                $address->user_id      = $user->id;
                $address->cep          = (string) preg_replace('/[^0-9]/', '', $request->input('cep'));
                $address->address      = $request->input('address');
                $address->complement   = $request->input('complement');
                $address->suburb       = $request->input('suburb');
                $address->city         = $request->input('city');
                $address->province     = $request->input('province');
                $address->country      = $request->input('country');
                $address->save();
                
                foreach ($request->input('phones') as $number) {
                    if (empty($number)) continue;
                    $phone = new Phone();
                    $phone->user_id      = $user->id;
                    $phone->number       = (string) preg_replace('/[^0-9]/', '', $number);
                    $phone->save();
                }

                DB::commit();

                $request->session()->flash('success', 'Usuário cadastrado com sucesso!');
                return redirect()->route('home');
            } catch (\Throwable $th) {
                DB::rollBack();

                $request->session()->flash('error', 'Erro ao tentar cadastrar o usuário! -> '.$th->getMessage());
            }
        }

        $data = [
            'title' => 'Cadastro'
        ];

        return view('register', $data);
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
        $valid = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        
        if ($valid)
        {
            $credentials = $request->only('email', 'password');
            $remember = $request->input('remember');

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

    public function getusers(Request $request)
    {
        $tag = $request->input('tag');
        $users = User::select('username','photo')->where('username', 'like', $tag.'%')->get();

        $correctarray = [];

        foreach($users as $user) {
            $correctarray[$user->username] = url('public/users/'.$user->photo);
        }

        return json_encode($correctarray);
    }
}
