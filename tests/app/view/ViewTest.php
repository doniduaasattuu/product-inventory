<?php

namespace App\Tests\app\view;

use App\Database\Seeds\Seed;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;

/**
 * @internal
 */
final class ViewTest extends CIUnitTestCase
{

    use DatabaseTestTrait;
    use FeatureTestTrait;

    private function migrate()
    {
        $migration = \Config\Services::migrations();
        $migration->setNamespace('App');
        $migration->latest();
        $this->seed('Seed');
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

    function testLoginView()
    {
        $result = $this->get('/login');


        $result->assertSee('Email');
        $result->assertSee('Password');
        $result->assertSee('Don\'t have an account ?');
        $result->assertSee('Login');
        $result->assertSee('Submit');
        $result->assertSee('Register here');
        $result->assertStatus(200);
    }

    function testRegistrationView()
    {
        $result = $this->get('/registration');


        $result->assertSee('Registration');
        $result->assertSee('Name *');
        $result->assertSee('Email *');
        $result->assertSee('Password *');
        $result->assertSee('Phone number');
        $result->assertSee('Registration code *');
        $result->assertSee('Submit');
        $result->assertSee('Already have an account ?');
        $result->assertSee('Login here');
        $result->assertStatus(200);
    }

    function testHomeView()
    {
        $result = $this->get('/');

        $result->assertSee('Product Inventory');
        $result->assertSee('Search');
        $result->assertSee('Scanner');
        $result->assertSee('Hello, guest');
        $result->assertSee('Filter');
        $result->assertSee('Category');
        $result->assertSee('Name');
        $result->assertSee('Category');
        $result->assertSee('Price');
        $result->assertSee('Stock');
        $result->assertSee('Beras');
        $result->assertSee('Updated at');
        $result->assertStatus(200);
    }

    function testHomeViewWithFilterCategoryComputer()
    {
        $result = $this->get('/?category=Computer');

        $result->assertSee('Product Inventory');
        $result->assertSee('Search');
        $result->assertSee('Scanner');
        $result->assertSee('Hello, guest');
        $result->assertSee('Filter');
        $result->assertSee('Category');
        $result->assertSee('Name');
        $result->assertSee('Category');
        $result->assertSee('Price');
        $result->assertSee('Stock');
        $result->assertSee('Updated at');
        $result->assertDontSee('Beras');
        $result->assertStatus(200);
    }

    function testProductDetailView()
    {
        $result = $this->get('/product-detail/662f1ad9aa70b');

        $result->assertSee('Product Inventory');
        $result->assertSee('Search');
        $result->assertSee('Scanner');
        $result->assertSee('Hello, guest');

        $result->assertSee('Product detail');
        $result->assertSee('Home');
        $result->assertSee('662f1ad9aa70b');
        $result->assertSee('Id');
        $result->assertSee('Name');
        $result->assertSee('Category');
        $result->assertSee('Price');
        $result->assertSee('Stock');
        $result->assertSee('22');
        $result->assertStatus(200);
    }
}
