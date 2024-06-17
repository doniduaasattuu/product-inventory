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

        if ($id == '' || $id == null || !is_null($id) ? strlen($id ?? '') < 13 : null) {
            session()->setFlashdata('alert', ['message' => "The product id entered is invalid.", 'variant' => 'alert-info']);
            return redirect()->back();
        }

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
