<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function registration()
    {
        return view('user/registration', [
            'title' => 'Registration',
        ]);
    }

    public function register()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => ['trim', 'required', 'min_length[3]', 'max_length[30]', 'alpha_space'],
            'email' => ['trim', 'required', 'valid_email'],
            'password' => ['trim', 'required', 'alpha_numeric_punct'],
            'phone_number' => ['trim', 'permit_empty', 'is_natural'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('user/registration', [
                'title' => 'Registration',
                'validation' => $validation,
            ]);
        }

        $db = db_connect();
        $builder = $db->table('users')->where('email', $this->request->getPost('email'));
        $user = $builder->get()->getFirstRow();

        if (!is_null($user)) {
            // USER IS EXISTS
            session()->setFlashData('alert', ['message' => 'The email has already been taken.']);
            return redirect()->back()->withInput();
        } else {
            // INSERT USER
            $user = model('User');
            $user->allowEmptyInserts()->insert($validation->getValidated());
            session()->setFlashData('alert', ['message' => 'Your account successfully created.', 'variant' => 'alert-success']);
            return $this->response->redirect('login');
        }
    }

    public function login()
    {
        return view('user/login', [
            'title' => 'Login',
        ]);
    }

    public function doLogin()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => ['required', 'valid_email'],
            'password' => ['required'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('user/login', ['validation' => $validation]);
        } else {

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $db = db_connect();
            $builder = $db->table('users')->where('email', $email);
            $user = $builder->get()->getFirstRow();

            if (!is_null($user) && $password == $user->password) {
                session()->set('user', [
                    'id' => $user->id ?? null,
                    'name' => $user->name ?? null,
                    'email' => $user->email ?? null,
                    'phone_number' => $user->phone_number ?? null,
                    'role' => $user->role ?? null,
                    'created_at' => $user->created_at ?? null,
                    'updated_at' => $user->updated_at ?? null,
                ]);
                return $this->response->redirect('/');
            } else {
                session()->setFlashData('alert', ['message' => 'The email or password is wrong.']);
                return redirect()->back()->withInput();
            }
        }
    }

    public function profile()
    {
        $db = db_connect();
        $columns = $db->getFieldData('users');

        $user = model('User')->find(session('user')['id']);

        return view('profile', [
            'columns' => $columns,
            'user' => $user,
        ]);
    }

    public function updateProfile()
    {
        $user = model('User')->find(session('user')['id']);

        return $this->response->setJSON($this->request->getPost());

        if (!is_null($user)) {
            // UPDATE PROFILE
            model('User')->where('id', $user['id'])->update($this->request->getPost());
            session()->setFlashData('alert', ['message' => 'Your profile successfully updated.', 'variant' => 'alert-success']);
            return redirect()->back()->withInput();
        } else {
            session()->setFlashData('alert', ['message' => 'User not found.', 'variant' => 'alert-info']);
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return $this->response->redirect('/');
    }
}
