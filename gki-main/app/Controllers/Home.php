<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('frontend/index');
    }

    //URL Kegiatan Gereja
    public function hutgereja()
    {
        return view('frontend/section/kgereja/hutgereja');
    }

    public function hutpi()
    {
        return view('frontend/section/kgereja/hutpi');
    }

    public function hutypk()
    {
        return view('frontend/section/kgereja/hutypk');
    }
}
