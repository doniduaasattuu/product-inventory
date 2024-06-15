<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
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

        $registration_code = getenv('REGISTRATION_CODE');

        $validation->setRules(
            [
                'name' => ['trim', 'required', 'min_length[3]', 'max_length[30]', 'alpha_space'],
                'email' => ['trim', 'required', 'valid_email'],
                'password' => ['trim', 'required', 'alpha_numeric_punct'],
                'phone_number' => ['trim', 'permit_empty', 'is_natural'],
                'registration_code' => ['trim', 'required', static fn ($value) => $value === $registration_code],
            ],
            [
                'registration_code' => [
                    2 => 'The registration_code is wrong.',
                ],
            ]
        );

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
                session()->set('user', $user);
                return redirect('/');
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

        return view('user/profile', [
            'title' => 'My profile',
            'columns' => $columns,
            'user' => (array) session()->get('user'),
        ]);
    }

    public function updateProfile()
    {
        $user_id = session()->get('user')->id;
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => ['trim', 'required', 'min_length[3]', 'max_length[30]', 'alpha_space'],
            'email' => ['trim', 'required', 'valid_email', 'is_not_unique[users.email]'],
            'password' => ['trim', 'required', 'alpha_numeric_punct'],
            'confirm_new_password' => ['trim', 'required', 'alpha_numeric_punct', 'matches[password]'],
            'phone_number' => ['trim', 'permit_empty', 'is_natural'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $validated = $validation->getValidated();
        $user = model('User')->where('id', $user_id);

        if (!is_null($user)) {
            try {

                // UPDATE PROFILE
                $user->update($user_id, [
                    'name' => $validated['name'],
                    'password' => $validated['password'],
                    'phone_number' => $validated['phone_number'],
                    'updated_at' => new RawSql('CURRENT_TIMESTAMP'),
                ]);

                session()->setFlashdata('alert', ['message' => 'Your profile successfully updated.', 'variant' => 'alert-success']);
                return redirect()->back();
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $error) {
                session()->setFlashdata('alert', ['message' => $error->getMessage()]);
                return redirect()->back();
            }
        } else {
            session()->setFlashData('alert', ['message' => 'User not found.', 'variant' => 'alert-info']);
            return redirect()->back()->withInput();
        }
    }

    public function users()
    {
        $users = model('User')->findAll();
        $db = db_connect();
        $query = $db->query('SELECT name, email, password, role FROM users');
        $user_columns = $query->getFieldData('users');

        return view('user/users', [
            'users' => $users,
            'title' => 'Users',
            'user_columns' => $user_columns,
        ]);
    }

    public function userReset($user_id)
    {
        $db = model('User');
        $user = $db->find($user_id);

        if (!is_null($user)) {
            $db->update($user_id, ['password' => 'rahasia']);
            session()->setFlashdata('alert', ['message' => 'User password reset successfully.', 'variant' => 'alert-success']);
            return redirect()->back();
        } else {
            session()->setFlashdata('alert', ['message' => 'User not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function userDelete($user_id)
    {
        $db = model('User');
        $user = $db->find($user_id);

        if (!is_null($user)) {
            try {
                $db->where('id', $user_id)->delete();
                session()->setFlashdata('alert', ['message' => 'User successfully deleted.', 'variant' => 'alert-success']);
                return redirect()->back();
            } catch (DatabaseException $error) {
                session()->setFlashdata('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('alert', ['message' => 'User not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function userRoleAssignment()
    {
        if ($this->request->isAJAX()) {

            $user_id = $this->request->getJsonVar('user_id');
            $new_request_role = $this->request->getJsonVar('role');

            $user = model('User')->find($user_id);

            if ($user) {

                if ($user['email'] == 'doni.duaasattuu@gmail.com') {
                    return response()->setJSON([
                        'response' => true,
                        'message' => 'Cannot unassign special user from manager.'
                    ]);
                } else {

                    model('User')->update($user_id, ['role' => $new_request_role ?? null]);

                    return response()->setJSON([
                        'response' => true,
                    ]);
                }
            } else {
                return response()->setJSON([
                    'response' => false,
                ]);
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return $this->response->redirect('/');
    }
}
