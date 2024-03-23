<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function scanner(): string
    {
        return view('scanner');
    }
}
