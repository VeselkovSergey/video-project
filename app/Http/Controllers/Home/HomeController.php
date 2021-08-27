<?php

namespace App\Http\Controllers\Home;

class HomeController
{
    public function Index()
    {
        return redirect(route('all-video-page'));
        return view('home.index');
    }
}
