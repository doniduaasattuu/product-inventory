<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;
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
        $filter = $this->request->getGet('filter');
        $category = $this->request->getGet('category');

        $db = db_connect();
        $product_column = $db->getFieldData('products');
        $products = model('Product')
            ->when($filter, static function ($query, $filter) {
                $query
                    ->orLike('id', "%{$filter}%")
                    ->orLike('name', "%{$filter}%")
                    ->orLike('stock', "%{$filter}%");
            })
            ->when($category, static function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('name')
            ->findAll();

        return view('products/home', [
            'categories' => $this->categories,
            'product_column' => $product_column,
            'products' => $products,
        ]);
    }

    public function productDetail($product_id)
    {
        $product = model('Product')->find($product_id);

        if (null != $product) {
            return view('products/product-detail', [
                'title' => 'Product detail',
                'categories' => model('Category')->findAll(),
                'product' => $product,
            ]);
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function productUpdate($product_id)
    {
        $product = model('Product')->find($product_id);

        if ($product) {
            return view('products/product-update', [
                'title' => 'Update product',
                'categories' => $this->categories,
                'product' => $product,
            ]);
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function scannedProduct($product_id)
    {
        $id = $this->request->getPost('search');

        $product = model('Product')->find($product_id);

        if ($product) {

            $view = 'products/product-detail';
            $title = 'Product detail';

            if (session()->get('user')) {
                $view = 'products/product-update';
                $title = 'Update product';
            }

            return view($view, [
                'title' => $title,
                'categories' => $this->categories,
                'product' => $product,
            ]);
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function updateProduct()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'id' => ['required', 'is_not_unique[products.id]'],
            'name' => ['required', 'min_length[3]', 'max_length[100]'],
            'category' => ['required'],
            'price' => ['permit_empty'],
            'stock' => ['permit_empty'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $product_id = $this->request->getPost('id');
        $product = model('Product')->where('id', $product_id);

        if (!is_null($product)) {

            try {
                // UPDATE PRODUCT
                $validated = array_merge($validation->getValidated(), ['updated_at' => new RawSql('CURRENT_TIMESTAMP')]);
                $product->update($product_id, $validated);
                session()->setFlashdata('alert', ['message' => 'Product successfully updated.', 'variant' => 'alert-success']);
                return redirect()->back();
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $error) {
                session()->setFlashdata('alert', ['message' => $error->getMessage()]);
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function productDelete($product_id)
    {
        $db = model('Product');
        $product = $db->find($product_id);

        if (!is_null($product)) {
            $db->where('id', $product_id)->delete();
            session()->setFlashdata('alert', ['message' => 'Product successfully deleted.', 'variant' => 'alert-success']);
            return redirect()->back();
        } else {
            session()->setFlashdata('alert', ['message' => 'Product not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }

    public function productNew()
    {
        return view('products/product-new', [
            'title' => 'New product',
            'categories' => $this->categories,
        ]);
    }

    public function insertProduct()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => ['required', 'min_length[3]', 'max_length[100]'],
            'category' => ['required'],
            'price' => ['permit_empty'],
            'stock' => ['permit_empty'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            // return view('products/product-new', [
            //     'title' => 'New product',
            //     'categories' => $this->categories,
            //     'validation' => $validation,
            // ]);
        }

        $validated = array_merge($validation->getValidated(), ['id' => uniqid(), 'created_at' => new RawSql('CURRENT_TIMESTAMP')]);
        $product = model('Product');

        try {
            // INSERT PRODUCT
            $product->insert($validated);
            session()->setFlashdata('alert', ['message' => 'Product successfully saved.', 'variant' => 'alert-success']);
            return redirect()->back();
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $error) {
            session()->setFlashdata('alert', ['message' => $error->getMessage()]);
            return redirect()->back();
        }
    }
}
