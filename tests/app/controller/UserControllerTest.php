<?php

namespace App\Tests\app\controller;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class UserControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    private function migrate()
    {
        $migration = \Config\Services::migrations();
        $migration->setNamespace('App');
        $migration->latest();
        $this->seed('App\Database\Seeds\Seed');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrate();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->migrate();
    }

    // LOGIN
    public function testLoginSuccess()
    {
        $result = $this
            ->post('/login', [
                'email' => 'anggigitacahyani@gmail.com',
                'password' => 'rahasia',
            ]);

        $result->assertStatus(302);
        $result->assertRedirect('/');
    }

    public function testLoginFailedWrongPassword()
    {
        $result = $this
            ->post('/login', [
                'email' => 'anggigitacahyani@gmail.com',
                'password' => 'salah',
            ]);

        $result->assertStatus(302);
        $result->assertRedirect('/login');
        $result->assertSessionHas('alert', ['message' => 'The email or password is wrong.']);
    }

    public function testLoginFailedEmailUnregistered()
    {
        $result = $this
            ->post('/login', [
                'email' => 'doni@gmail.com',
                'password' => 'salah',
            ]);

        $result->assertStatus(302);
        $result->assertRedirect('/login');
        $result->assertSessionHas('alert', ['message' => 'The email or password is wrong.']);
    }

    // REGISTRATION
    public function testRegistrationSuccess()
    {
        $result = $this
            ->post('/registration', [
                'name' => 'Doni Darmawan',
                'email' => 'doni@gmail.com',
                'password' => 'rahasia',
                'phone_number' => '08983456945',
                'registration_code' => 'rahasia',
            ]);

        $result->assertStatus(302);
        $result->assertRedirect('/login');
        $result->assertSessionHas('alert', ['message' => 'Your account successfully created.', 'variant' => 'alert-success']);
    }

    public function testRegistrationFailedNameEmpty()
    {
        $result = $this
            ->post('/registration', [
                'name' => null,
                'email' => 'doni@gmail.com',
                'password' => 'rahasia',
                'phone_number' => '08983456945',
                'registration_code' => 'rahasia',
            ]);

        $result->assertStatus(200);
        $result->assertSee('The name field is required.');
    }

    public function testRegistrationFailedEmailEmpty()
    {
        $result = $this
            ->post('/registration', [
                'name' => 'Doni Darmawan',
                'email' => null,
                'password' => 'rahasia',
                'phone_number' => '08983456945',
                'registration_code' => 'rahasia',
            ]);

        $result->assertStatus(200);
        $result->assertSee('The email field is required.');
    }

    public function testRegistrationFailedEmailDuplicate()
    {
        $this->seed('Seed');

        $result = $this
            ->post('/registration', [
                'name' => 'Doni Darmawan',
                'email' => 'anggigitacahyani@gmail.com',
                'password' => 'rahasia',
                'phone_number' => '08983456945',
                'registration_code' => 'rahasia',
            ]);

        $result->assertStatus(302);
        $result->assertRedirect('/registration');
        $result->assertSessionHas('alert', ['message' => 'The email has already been taken.']);
    }

    public function testRegistrationFailedPasswordEmpty()
    {
        $result = $this
            ->post('/registration', [
                'name' => 'Doni Darmawan',
                'email' => 'doni@gmail.com',
                'password' => null,
                'phone_number' => '08983456945',
                'registration_code' => 'rahasia',
            ]);

        $result->assertStatus(200);
        $result->assertSee('The password field is required.');
    }

    public function testRegistrationFailedRegistrationCodeEmpty()
    {
        $result = $this
            ->post('/registration', [
                'name' => 'Doni Darmawan',
                'email' => 'doni@gmail.com',
                'password' => 'rahasia',
                'phone_number' => '08983456945',
                'registration_code' => null,
            ]);

        $result->assertStatus(200);
        $result->assertSee('The registration_code field is required.');
    }

    public function testRegistrationFailedWrongRegistrationCode()
    {
        $result = $this
            ->post('/registration', [
                'name' => 'Doni Darmawan',
                'email' => 'doni@gmail.com',
                'password' => 'rahasia',
                'phone_number' => '08983456945',
                'registration_code' => 'wrong',
            ]);

        $result->assertStatus(200);
        $result->assertSee('The registration_code is wrong.');
    }
}
