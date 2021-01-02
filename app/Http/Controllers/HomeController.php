<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = 'Home';

        if (Auth::check()) {
            $posts = Blog::selectRaw('blog.*, users.tagname, count(blog_comments.id) as comments_count')
                ->leftJoin('blog_comments','blog_comments.post','=','blog.id')
                ->rightJoin('users','users.id','=','blog.created_by')
                ->orderBy('id', 'desc')
                ->groupBy('blog.id')
                ->get();

            foreach ($posts as &$post) {
                $post->comments = Comments::where('post', '=', $post->id)
                    ->orderBy('updated_at')
                    ->get();
            }

            $data['posts'] = $posts;

            return view('home', $data);
        }

        return view('login', $data);
    }
}
