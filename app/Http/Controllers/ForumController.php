<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Forum;

class ForumController extends Controller
{
    private $data;

    public function __construct()
    {
        $this->data = [
            'title' => 'Forum'
        ];
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $this->data['topics'] = Forum::all();
            return view('forum.page', $this->data);
        }
        
        return view('forum.home', $this->data);
    }

    public function create(Request $request)
    {
        return view('forum.create', $this->data);
    }
}