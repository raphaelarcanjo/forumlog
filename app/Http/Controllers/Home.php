<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function index()
    {
        return view('home', ['title' => 'Home']);
    }

    public function about()
    {
        return view('about', ['title' => 'Sobre']);
    }

    public function forum()
    {
        return view('forum.home', ['title' => 'Forum']);
    }

    public function blog()
    {
        if (session('user') && session('token'))
        {
            if (session('token') == md5(session('user').'teste123'))
            {
                return redirect('forumlog/user/blog/'.session('user'));
            }
        }
        
        return view('blog.home', ['title' => 'Blog']);
    }

    public function contact()
    {
        return view('home', ['title' => 'Home']);
    }
}
