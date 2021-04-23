<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\Comments;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = 'Home';

        if (Auth::check()) {
            $posts = Blog::selectRaw('blog.*, users.tagname, users.name as user_name, count(blog_comments.id) as comments_count')
                ->leftJoin('blog_comments','blog_comments.post','=','blog.id')
                ->join('users','users.id','=','blog.created_by')
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
