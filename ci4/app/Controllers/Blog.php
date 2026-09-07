<?php

namespace App\Controllers;

use App\Models\Content;

class Blog extends BaseController
{
    public function index()
    {
        $model = new Content();
        $data['posts'] = $model->where('deleted_at', null)
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        $data['content'] = view('home/content/blog', $data);
        return view('home/layout', $data);
    }
    public function content($title){
        $model = new Content();
        $data['post'] = $model->where('slug', $title)
                               ->where('deleted_at', null)
                               ->first();
        $data['content'] = view('home/content/contentBlog', $data);
        return view('home/layout', $data);
    }
}


