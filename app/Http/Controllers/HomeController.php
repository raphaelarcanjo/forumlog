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
            $blogs = Blog::selectRaw('blogs.*, users.username, users.name as user_name, count(blog_comments.id) as comments_count')
                ->leftJoin('blog_comments','blog_comments.blog_id','blogs.id')
                ->join('users','users.id','blogs.user_id')
                ->orderBy('id', 'desc')
                ->groupBy(['blogs.id', 'users.username', 'users.name'])
                ->get();
            // $blogs = Blog::withCount('comments')
            //     ->with('user')
            //     ->with('comments', 'comments.user')
            // ->orderBy('blogs.id', 'desc')
            //     ->get();

            foreach ($blogs as &$blog) {
                $blog->comments = BlogComment::selectRaw('blog_comments.*, users.name author_name')
                    ->where('blog_id', $blog->id)
                    ->leftJoin('users', 'users.id', 'blog_comments.user_id')
                    ->orderBy('updated_at')
                    ->get();
            }

            $data['blogs'] = $blogs;

            return view('home', $data);
        }

        return view('login', $data);
    }
}
