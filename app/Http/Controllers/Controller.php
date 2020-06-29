<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if (!session('user') && !session('token')) {
            if (isset($_COOKIE['user']) && isset($_COOKIE['token'])) {
                if ($_COOKIE['token'] === md5($_COOKIE['user'].'teste123')) {
                    session(['token' => md5($_COOKIE['user'].'teste123')]);
                    session(['user' => $_COOKIE['user']]);
                    $user = new User();
                    session(['allusers' => $user->get('tagname', 'photo')]);
                }
            }
        }
    }
}
