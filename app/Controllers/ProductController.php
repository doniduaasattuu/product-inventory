<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $categories = model('Category')->findAll();
        $products = model('Product')->findAll();
        $product_column = $db->getFieldData('products');

        return view('home', [
            'categories' => $categories,
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
        return 'update ' . $product_id;
    }

    public function productDelete($product_id)
    {
        return 'delete ' . $product_id;
    }

    public function newProduct()
    {
        return view('new-product');
    }
}
