<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Forum'
        ];
        if (Auth::check()) {
            $data['topics'] = Forum::all();
            return view('forum.page', $data);
        }
        
        return view('forum.home', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'title' => 'Forum'
        ];

        return view('forum.create', $data);
    }
}