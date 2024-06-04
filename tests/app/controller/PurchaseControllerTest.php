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
final class PurchaseControllerTest extends CIUnitTestCase
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

    public function testPurchasePage()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase');

        $result->assertSee('Purchases');
        $result->assertSee('New Purchase');
        $result->assertSee('Start date');
        $result->assertSee('End date');
        $result->assertSee('Default value is year to date.');
        $result->assertSee('Purchase trends');
        $result->assertSee('Total');
        $result->assertSee('Purchase Data');
        $result->assertSee('Id');
        $result->assertSee('Supplier');
        $result->assertSee('Status');
        $result->assertSee('Admin');
        $result->assertSee('Total');
        $result->assertSee('Created at');
        $result->assertSee('Updated at');
        $result->assertSee('Detail');
        $result->assertSee('Delete');
    }

    public function testNewPurchasePage()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $result = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase-new');

        $result->assertSee('Purchases');
        $result->assertSee('New');
        $result->assertSee('Filter');
        $result->assertSee('Product name');
        $result->assertSee('Category');
        $result->assertSee('Name');
        $result->assertSee('Category');
        $result->assertSee('Price');
        $result->assertSee('Stock');
        $result->assertSee('Add');
    }
}
