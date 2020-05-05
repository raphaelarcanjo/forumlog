<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Support\Facades\Mail;
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

    public function blog($tagname = null)
    {
        if (session('user') && session('token'))
        {
            if (session('token') == md5(session('user').'teste123'))
            {
                return redirect('forumlog/user/blog/'.session('user'));
            }
        }

        if ($tagname) return redirect('/forumlog/user/blog/'.$tagname);
        
        return view('blog.home', ['title' => 'Blog']);
    }

    public function contact(Request $request)
    {
        $valid = $request->validate([
            'name'      => 'required|max:80',
            'email'     => 'required|max:80',
            'subject'   => 'required|max:40',
            'message'   => 'required'
        ]);

        $data['name'] = $request->input('name').' - '.$request->input('email');
        $data['subject'] = $request->input('subject');
        $data['message'] = $request->input('message');

        Mail::send(new Contact($data));

        $request->session()->flash('success','Mensagem enviada com sucesso. Agradecemos pelo seu contato!');
        return redirect('forumlog');
    }
}
