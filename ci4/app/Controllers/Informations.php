<?php

namespace App\Controllers;

class Informations extends BaseController
{
    public function index()
    {
        $data['content']=view('home/content/informations');
        return view('home/layout', $data);
    }
    public function info($title=null){
        $data['content']=view('home/content/info');
        return view('home/layout', $data);
    }
}


