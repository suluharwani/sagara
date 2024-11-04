<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function index()
    {
        $data['content']=view('home/content/blog');
        return view('home/index', $data);
    }
    public function content($title){
        $data['content']=view('home/content/contentBlog');
        return view('home/index', $data);
    }
}
