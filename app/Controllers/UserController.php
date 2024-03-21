<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function login()
    {
        return view('user/login');
    }
    public function doLogin()
    {
        $this->request->getPost('email');
    }
}
