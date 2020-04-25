<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function blog()
    {
        return view('blog.home', ['title' => 'Blog']);
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $data['title'] = 'Cadastro';
        
        return view('register',$data);
    }

    public function login()
    {
        return view('home',['title' => 'Home']);
    }

    public function recover()
    {
        return view('home',['title' => 'Home']);
    }
}
