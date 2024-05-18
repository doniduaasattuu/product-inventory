<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function scanner(): string
    {
        return view('scanner');
    }

    public function search()
    {
        $id = $this->request->getPost('search');

        $product = model('Product')->find($id);

        if (null != $product) {

            $view = 'products/product-detail';
            $title = 'Detail product';

            if (session()->get('user')) {
                $view = 'products/product-update';
                $title = 'Update product';
            }

            return view($view, [
                'title' => $title,
                'categories' => model('Category')->findAll(),
                'product' => $product,
            ]);
        } else {
            session()->setFlashdata('alert', ['message' => "Product with ID $id not found.", 'variant' => 'alert-info']);
            return redirect()->back();
        }
    }
}
