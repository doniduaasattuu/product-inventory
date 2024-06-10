<?php

namespace App\Tests\app\controller;

use App\Database\Seeds\Seed;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Model;
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

    // UNIT TEST
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

    public function testAddItemToPurhaseOrder()
    {

        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $orders = model('PurchaseOrder')->findAll();
        self::assertEmpty($orders);

        $success = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase-order/662f1ad9aa70b');

        $success->assertStatus(302);
        $success->assertSessionHas('alert', ['message' => 'Product with id 662f1ad9aa70b added to purchase order.', 'variant' => 'alert-success']);
    }

    public function testAddSameItemToPurhaseOrder()
    {

        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $this->testAddItemToPurhaseOrder();

        $orders = model('PurchaseOrder')->findAll();
        self::assertNotEmpty($orders);

        $success = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase-order/662f1ad9aa70b');

        $success->assertStatus(302);
        $success->assertSessionHas('alert', ['message' => 'Successfully add quantity.', 'variant' => 'alert-info']);
    }

    public function testAddItemFailedProductPrice()
    {

        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $orders = model('PurchaseOrder')->findAll();
        self::assertEmpty($orders);

        $success = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase-order/662f1ad9aa123');

        $success->assertStatus(302);
        $success->assertSessionHas('alert', ['message' => 'Product price is invalid.', 'variant' => 'alert-danger']);
    }

    public function testPurchaseOrderPageEmpty()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        db_connect()->table('purchase_orders')->emptyTable();

        $purchase_order = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase-order');

        $purchase_order->assertStatus(302);
        $purchase_order->assertSessionHas('alert', ['message' => "Purchase order not found.", 'variant' => 'alert-info']);
    }

    public function testPurchaseOrderPageNotEmpty()
    {
        $user = $this->loggedIn('anggigitacahyani@gmail.com');

        $this->testAddItemToPurhaseOrder();

        $purchase_order = $this
            ->withSession([
                'user' => $user
            ])
            ->get('/purchase-order');

        $purchase_order->assertStatus(200);
        $purchase_order->assertSee('Purchase order');
        $purchase_order->assertSee('Back');
        $purchase_order->assertSee('Order');
        $purchase_order->assertSee('Product id');
        $purchase_order->assertSee('Product name');
        $purchase_order->assertSee('Product category');
        $purchase_order->assertSee('Product price');
        $purchase_order->assertSee('Quantity');
        $purchase_order->assertSee('Sub total');
        $purchase_order->assertSee('Delete');
        $purchase_order->assertSee('Submit');
    }
}
