<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = 'Home';

        if (session('user') && session('token')) {
            $posts = new Blog();
            $data['posts'] = $posts->orderBy('id', 'desc')->get();
            $comments = new Comments();
            $data['comments'] = $comments->get();
        }

        return view('home', $data);
    }
}
