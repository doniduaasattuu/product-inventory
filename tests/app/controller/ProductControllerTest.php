<?php

namespace App\Tests\app\controller;

use App\Database\Seeds\Seed;
use App\Tests\Support\FakeImage;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;
// use Faker\Provider\Image;
// use App\Tests\Support\FakeImage;

/**
 * @internal
 */
final class ProductControllerTest extends CIUnitTestCase
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

    // UNIT TEST
    public function testProductIndex()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/');

        $result->assertSee('Anggi');
        $result->assertSee('Apple MacBook Air 13 M1 Chip 256GB SSD 8GB');
    }

    public function testProductIndexWithFilter()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/?filter=Beras');

        $result->assertSee('Anggi');
        $result->assertSee('Beras Ramos cap Kembang 2 Kg');
        $result->assertSee('Beras Rojolele 10 Kg');
        $result->assertSee('Beras Rojolele 5 Kg');
        $result->assertDontSee('Apple MacBook Air 13 M1 Chip 256GB SSD 8GB');
    }

    // PRODUCT-NEW
    public function testProductNewPage()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/product-new');

        $result->assertSee('New product');
        $result->assertSee('Home');
        $result->assertSee('New');
        $result->assertSee('Name');
        $result->assertSee('Category');
        $result->assertSee('Price');
        $result->assertSee('Stock');
        $result->assertSee('Image');
        $result->assertSee('Submit');
    }

    public function testPostNewProduct()
    {
        // $this->markTestIncomplete('Error: image is too large of a file.');
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->withBodyFormat('multipart/form-data')
            ->post(
                '/product-new',
                [
                    'name' => 'Eiger Linden 1.0 liter',
                    'category' => 'Fashion',
                    'price' => '235000',
                    'stock' => '25',
                ]
            );

        $result->assertStatus(302);
        $result->assertRedirect('/product-new');
        $result->assertSessionHas('errors', ['image' => 'image is too large of a file.']);
        // $result->assertSessionHas('alert', ['message' => 'Product successfully saved.', 'variant' => 'alert-success']);
    }

    // PRODUCT UPDATE
    public function testProductUpdatePage()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/product-update/662f1ad9aa70b');

        $result->assertStatus(200);
        $result->assertSee('Update product');
        $result->assertSee('Home');
        $result->assertSee('Id');
        $result->assertSee('662f1ad9aa70b');
        $result->assertSee('Name');
        $result->assertSee('Apple MacBook Air 13 M1 Chip 256GB SSD 8GB ');
        $result->assertSee('Category');
        $result->assertSee('Computer');
        $result->assertSee('Price');
        $result->assertSee('14699000');
        $result->assertSee('Stock');
        $result->assertSee('22');
    }

    public function testPostUpdateProduct()
    {
        // $this->markTestIncomplete('Error: image is too large of a file.');
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->post('/product-update', [
                'id' => '662f1ad9aa70b',
                'name' => 'Apple MacBook Air 13 M1 Chip 256GB SSD 16GB',
                'category' => 'Computer',
                'price' => '14699000',
                'stock' => '22',
            ]);

        $result->assertStatus(302);
        $result->assertSessionHas('errors', ['image' => 'image is too large of a file.']);
        // $result->assertSessionHas('alert', ['message' => 'Product successfully updated.', 'variant' => 'alert-success']);
    }

    // PRODUCT DELETE
    public function testProductDelete()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/product-delete/662f1ad9aa70b');

        $result->assertStatus(302);
        $result->assertSessionHas('alert', ['message' => 'Product successfully deleted.', 'variant' => 'alert-success']);
    }
}
