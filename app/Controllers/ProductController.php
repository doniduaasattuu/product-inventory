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
        $filter = $this->request->getGet('filter');
        $category = $this->request->getGet('category');

        $db = db_connect();
        $product_column = $db->getFieldData('products');
        $products = model('Product')
            ->when($filter, static function ($query, $filter) {
                $query->like('name', "%{$filter}%");
            })
            ->when($category, static function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('updated_at', 'DESC')
            ->findAll();

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
            'category' => ['required', 'is_unique[categories.category]', 'min_length[3]', 'max_length[25]'],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('categories', [
                'title' => 'Categories',
                'categories' => $this->categories,
                'validation' => $validation,
            ]);
        }
        model('Category')->insert($validation->getValidated());
        session()->setFlashdata('alert', ['message' => 'Category successfully saved.', 'variant' => 'alert-success']);
        return $this->response->redirect('categories');
    }

    public function categoryDelete($category_id)
    {
        $db = model('Category');
        $category = $db->find($category_id);

        if (!is_null($category)) {
            try {
                $db->where('category', $category_id)->delete();
                session()->setFlashdata('alert', ['message' => 'Category successfully deleted.', 'variant' => 'alert-success']);
                return redirect()->back();
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $error) {
                session()->setFlashdata('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('alert', ['message' => 'Category not found.', 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }
}
