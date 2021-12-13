<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = 'Home';

        if (Auth::check()) {
            $blogs = Blog::withCount('comments')
                ->with('user')
                ->with('comments', 'comments.user')
            ->orderBy('blogs.id', 'desc')
                ->get();

            $data['blogs'] = $blogs;

            return view('home', $data);
        }

        return view('login', $data);
    }
}
