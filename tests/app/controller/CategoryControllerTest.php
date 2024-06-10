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
final class CategoryControllerTest extends CIUnitTestCase
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

    // CATEGORIES
    public function testCategoryPage()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/categories');

        $result->assertSee('Categories');
        $result->assertSee('Home');
        $result->assertSee('New category');
        $result->assertSee('Automotive');
        $result->assertSee('Book');
        $result->assertSee('Computer');
        $result->assertSee('Electronic');
        $result->assertSee('Fashion');
        $result->assertSee('Food');
        $result->assertSee('Gadget');
        $result->assertSee('Photography');
    }

    // CATEGORY NEW
    public function testCategoryNew()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->post('/category-new', [
                'category' => 'Electricity'
            ]);

        $result->assertStatus(302);
        $result->assertSessionHas('alert', ['message' => 'Category successfully saved.', 'variant' => 'alert-success']);

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/categories');

        $result->assertSee('Electricity');
    }

    // CATEGORY DELETE
    public function testCategoryDeleteSuccess()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/category-delete/Automotive');

        $result->assertStatus(302);
        $result->assertSessionHas('alert', ['message' => 'Category successfully deleted.', 'variant' => 'alert-success']);

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/categories');

        $result->assertDontSee('Automotive');
    }

    public function testCategoryDeleteFailedConstraint()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/category-delete/Book');

        $result->assertStatus(302);
        $result->assertSessionHas('alert', ['message' => "Cannot delete or update a parent row: a foreign key constraint fails (`product_inventory`.`products`, CONSTRAINT `products_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`category`))", 'variant' => 'alert-danger']);

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/categories');

        $result->assertSee('Book');
    }
}
