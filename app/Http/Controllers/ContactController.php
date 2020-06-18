<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
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
