<?php

namespace App\Tests\app\controller;

use App\Database\Seeds\Seed;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;

/**
 * @internal
 */
final class HomeControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    private function loggedIn(String $email)
    {
        $db = db_connect();
        $builder = $db->table('users')->where('email', $email);
        $user = $builder->get()->getFirstRow();

        return $user;
    }

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

    public function testSearchFound()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');


        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->post('/search', [
                'search' => '662f1ad9aa123'
            ]);

        $result->assertStatus(200);
        $result->assertSee('Update product');
        $result->assertSee('Id');
        $result->assertSee('662f1ad9aa123');
        $result->assertSee('Name');
        $result->assertSee('Abjad Cinta');
        $result->assertSee('Category');
        $result->assertSee('Book');
        $result->assertSee('Price');
        $result->assertSee('0');
        $result->assertSee('Stock');
        $result->assertSee('4');
        $result->assertSee('Update');
        $result->assertDontSee('Submit');
    }

    public function testSearchNotFound()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');


        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->post('/search', [
                'search' => '662f1ad9aaabc'
            ]);

        $result->assertStatus(302);
        $result->assertSessionHas('alert', ['message' => "Product with ID 662f1ad9aaabc not found.", 'variant' => 'alert-info']);
    }
}
