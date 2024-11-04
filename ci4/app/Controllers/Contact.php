<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        $data['content']=view('home/content/contact');
        return view('home/index', $data);
    }
}
