<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CategoryController extends BaseController
{
    private $categories;

    public function __construct()
    {
        $this->categories = model('Category')->findAll();
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
