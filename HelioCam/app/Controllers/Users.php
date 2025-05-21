<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Users extends BaseController
{
    public function index()
    {
        helper(['form']);
        return view('login');
    }

    public function register()
    {
        helper(['form']);
        return view('register');
    }

    public function home()
    {
        return view('home');
    }

    public function addsession()
    {
        return view('addsession');
    }

    public function hostsession()
    {
        return view('hostsession');
    }

    public function surveillance()
    {
        return view('surveillance');
    }

    public function notification()
    {
        return view('notification');
    }

    public function settings()
    {
        return view('settings');
    }

    public function verify()
    {
        return view('verify');
    }

    public function about_us()
    {
        return view('about_us');
    }

    public function contact_us()
    {
        return view('contact_us');
    }

    public function policy()
    {
        return view('policy');
    }

    public function terms()
    {
        return view('terms');
    }

    public function streaming()
    {
        return view('streaming');
    }

    public function profile()
    {
        return view('profile');
    }

    public function history()
    {
        return view('history');
    }
 public function eprofile()
{
    return view('eprofile');
}
 public function forgot_pass()
{
    return view('request_link');
}
}