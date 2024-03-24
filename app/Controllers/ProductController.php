<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\RawSql;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    private $categories;

    public function __construct()
    {
        $this->categories = model('Category')->findAll();
    }

    public function index(): string
    {
        $db = db_connect();
        $products = model('Product')->findAll();
        $product_column = $db->getFieldData('products');

        return view('home', [
            'categories' => $this->categories,
            'product_column' => $product_column,
            'products' => $products,
        ]);
    }

    public function productDetail($product_id)
    {
        return 'detail ' . $product_id;
        return view('product-detail', [
            'product_id' => $product_id,
        ]);
    }

    public function productUpdate($product_id)
    {
        $product = model('Product')->find($product_id);

        return view('product-update', [
            'title' => 'Update product',
            'categories' => $this->categories,
            'product' => $product,
        ]);
    }

    public function updateProduct()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'id' => ['required', 'is_not_unique[products.id]'],
            'name' => ['required', 'min_length[3]', 'max_length[25]'],
            'category' => ['required'],
            'price' => ['permit_empty'],
            'stock' => ['permit_empty'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $product_id = $this->request->getPost('id');
        $product = model('Product')->find($product_id);

        if (!is_null($product)) {
            // do update
            session()->setFlashdata('alert', ['message' => 'Product successfully updated.', 'variant' => 'alert-success']);
            return redirect()->back();
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function productDelete($product_id)
    {
        $product = model('Product')->where('id', $product_id);

        if (!is_null($product)) {
            $product->delete();
            session()->setFlashdata('alert', ['message' => 'Product successfully deleted.', 'variant' => 'alert-success']);
            return redirect()->back();
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function productNew()
    {
        return view('product-new', [
            'title' => 'New product',
            'categories' => $this->categories,
        ]);
    }

    public function insertProduct()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => ['required', 'min_length[3]', 'max_length[25]'],
            'category' => ['required'],
            'price' => ['permit_empty'],
            'stock' => ['permit_empty'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('product-new', [
                'title' => 'New product',
                'categories' => $this->categories,
                'validation' => $validation,
            ]);
        }

        $validated = array_merge($validation->getValidated(), ['id' => uniqid(), 'created_at' => new RawSql('CURRENT_TIMESTAMP')]);
        $product = model('Product');
        $product->insert($validated);

        session()->setFlashdata('alert', ['message' => 'Product successfully saved.', 'variant' => 'alert-success']);
        return redirect()->back();
        // return $this->response->setJSON($validated);
    }

    public function categories()
    {
        return view('categories', [
            'title' => 'Categories',
            'categories' => $this->categories,
        ]);
    }

    public function insertCategory()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'category' => ['required', 'is_unique[categories.category]'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('categories', [
                'title' => 'Categories',
                'categories' => $this->categories,
                'validation' => $validation,
            ]);
        }

        // return $this->response->setJSON($validation->getValidated());
        model('Category')->insert($validation->getValidated());
        session()->setFlashdata('alert', ['message' => 'Category successfully saved.', 'variant' => 'alert-success']);
        return $this->response->redirect('categories');
    }
}
