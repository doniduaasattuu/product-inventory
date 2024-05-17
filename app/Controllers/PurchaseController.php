<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Carbon\Carbon;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PurchaseController extends BaseController
{
    private $categories;
    private $purchase_column;
    private $purchase_detail_column;

    public function __construct()
    {

        $this->purchase_column = db_connect()->getFieldData('purchases');
        $this->purchase_detail_column = db_connect()->getFieldData('purchase_details');
        $this->categories = model('Category')->findAll();
    }

    public function index()
    {
        $filter = $this->request->getGet('filter');
        $start_date = $this->request->getGet('start_date') ?? Carbon::now()->addDays(-30);
        $end_date = $this->request->getGet('end_date') ?? Carbon::now()->addDays(1)->toDateString();

        $purchase_model = model('Purchase');
        $purchases = $purchase_model
            ->when($filter, static function ($query, $filter) {
                $query
                    ->orLike('id', "%{$filter}%")
                    ->orLike('name', "%{$filter}%")
                    ->orLike('stock', "%{$filter}%");
            })
            ->when(($start_date && $start_date), static function ($query) use ($start_date, $end_date) {
                $query
                    ->where("created_at BETWEEN '$start_date' AND '$end_date'");
            })
            ->findAll();

        $created_at = [];
        $admin = [];
        $total = [];
        $user_table = db_connect()->table('users');
        foreach ($purchases as $purchase) {
            array_push($created_at, Carbon::create($purchase['created_at'])->format('d/m/y'));
            array_push($admin, $user_table->where('email', 'doni.duaasattuu@gmail.com')->get()->getFirstRow()->name);
            array_push($total, $purchase['total']);
        }

        return view('purchase/home', [
            'purchase_column' => $this->purchase_column,
            'purchases' => $purchases,
            'created_at' => $created_at,
            'admin' => $admin,
            'total' => $total,
        ]);
    }

    public function purchaseDetail($purchase_id)
    {
        $purchase_details = db_connect()->table('purchase_details')->where('purchase_id', $purchase_id)->get()->getResultArray();
        $purchase = db_connect()->table('purchases')->where('id', $purchase_id)->get()->getFirstRow();

        if ($purchase_details) {

            return view('purchase/details', [
                'title' => 'Purchase detail',
                'purchase_id' => $purchase_id,
                'purchase' => $purchase,
                'purchase_details' => $purchase_details,
                'purchase_details_column' => db_connect()->getFieldData('purchase_details'),
            ]);
        } else {
            session()->setFlashdata('modal', ['message' => 'Purchase detail not found.']);
            return redirect()->back();
        }
    }

    public function purchaseDelete($purchase_id)
    {
        $purchase_table = db_connect()->table('purchases');
        $purchase_details_table = db_connect()->table('purchase_details');

        $purchase = $purchase_table->where('id', $purchase_id)->get()->getFirstRow();
        $purchase_detail = $purchase_details_table->where('purchase_id', $purchase_id)->get()->getResultObject();

        if ($purchase) {

            // DELETE PURCHASE DETAIL
            if (null != $purchase_detail) {
                foreach ($purchase_detail as $detail) {
                    $purchase_details_table->delete(['purchase_id' => $detail->purchase_id]);
                }
            }

            $purchase_table->delete(['id' => $purchase->id]);
            session()->setFlashdata('modal', ['message' => 'Purchase record successfully deleted.']);
            return redirect()->back();
        } else {
            session()->setFlashdata('modal', ['message' => 'Purchase not found.']);
            return redirect()->back();
        }
    }

    public function purchaseNew()
    {
        $filter = $this->request->getGet('filter');
        $category = $this->request->getGet('category');

        $db = db_connect();
        $product_column = $db->getFieldData('products');
        $products = model('Product')
            ->when($filter, static function ($query, $filter) {
                $filter = trim($filter);
                $query
                    ->orLike('id', "%{$filter}%")
                    ->orLike('name', "%{$filter}%")
                    ->orLike('stock', "%{$filter}%");
            })
            ->when($category, static function ($query, $category) {
                $category = trim($category);
                $query->where('category', $category);
            })
            ->orderBy('name')
            ->findAll();

        $purchase_orders = model('PurchaseOrder')->findAll();

        return view('purchase/new', [
            'title' => 'New Purchase',
            'product_column' => $product_column,
            'products' => $products,
            'categories' => $this->categories,
            'purchase_orders' => $purchase_orders,
        ]);
    }

    public function purchaseOrderAdd($product_id)
    {
        $product_model = model('Product');
        $product = $product_model->find($product_id);

        $product_exist = model('PurchaseOrder')->where('product_id', $product_id)->find();

        // return response()->setJSON($product_exist[0]);

        if ($product_exist) {

            $current_quantity = intval($product_exist[0]['quantity']);
            $new_quantity = $current_quantity + 1;

            $data = [
                'quantity' => $new_quantity,
            ];

            model('PurchaseOrder')->update($product_exist[0]['id'], $data);

            session()->setFlashdata('alert', ['message' => 'Successfully add quantity.', 'variant' => 'alert-info']);
            return redirect()->back();
        }

        if ($product) {

            $data = [
                'product_id' => $product['id'],
                'product_name' => $product['name'],
                'product_category' => $product['category'],
                'product_price' => $product['price'],
                'quantity' => 1,
            ];

            // return response()->setJSON($product['price']);

            if ($product['price'] <= 0) {

                session()->setFlashdata('alert', ['message' => "Product price is invalid.", 'variant' => 'alert-danger']);
                return redirect()->back();
            } else {

                model('PurchaseOrder')->insert($data);

                session()->setFlashdata('alert', ['message' => "Product with id $product_id added to purchase order.", 'variant' => 'alert-success']);
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('alert', ['message' => "Product wih id $product_id not found.", 'variant' => 'alert-danger']);
            return redirect()->back();
        }
    }

    public function purchaseOrder()
    {
        $db = db_connect();
        $purchase_order_column = $db->getFieldData('purchase_orders');

        $purchase_orders = model('PurchaseOrder')->findAll();

        return view('/purchase/order', [
            'title' => 'Purchase order',
            'purchase_order_column' => $purchase_order_column,
            'purchase_orders' => $purchase_orders,
            'action' => '/purchase-detail',
        ]);

        return response()->setJSON(model('PurchaseOrder')->findAll());
    }

    public function purchaseOrderDelete()
    {
        model('PurchaseOrder')->truncate();
        session()->setFlashdata('alert', ['message' => 'Purchase order successfully deleted.', 'variant' => 'alert-info']);
        return redirect('purchase-new');
    }

    public function purchaseDetailSubmit()
    {
        $data_request = $this->request->getPost('data');
        // return response()->setJSON($this->request->getPost());
        $purchase_id = uniqid('pc_');

        $total = 0;
        $data = [];
        foreach ($data_request as $dt) {
            $dt['purchase_id'] = $purchase_id;
            $total += (int) $dt['sub_total'];

            array_push($data, $dt);
        }

        $db = db_connect();

        $db->transStart();
        $db->table('purchases')->insert([
            'id' => $purchase_id,
            'supplier' => null,
            'status' => 'Pending',
            'admin_email' => session()->get('user')->email,
            'total' => $total,
        ]);

        $db->table('purchase_details')->insertBatch($data);
        $db->table('purchase_orders')->truncate();
        $db->transComplete();

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('modal', ['message' => 'Error occured.']);
            return redirect('purchase');
        } else {
            session()->setFlashdata('modal', ['message' => 'Saved successfully.']);
            return redirect('purchase');
        }
    }

    public function purchaseUpdate($purchase_id)
    {
        $purchase = model('Purchase')->find($purchase_id);
        $purchase_detail = model('PurchaseDetail')->where('purchase_id', $purchase_id)->findAll();
        $admin_email = model('User')->select('email')->findAll();

        if ($purchase_detail) {
            return view('purchase/update', [
                'purchase_id' => $purchase_id,
                'purchase' => $purchase,
                'purchase_column' => $this->purchase_column,
                'admin_email' => $admin_email,
                'purchase_detail' => $purchase_detail,
                'purchase_detail_column' => $this->purchase_detail_column,
                'status' => ['Pending', 'Approved', 'Done'],
            ]);
        } else {
            session()->setFlashdata('modal', ['message' => 'Purchase detail not found.']);
            return redirect()->back();
        }
    }

    public function purchaseUpdateEnd()
    {
        $data = $this->request->getPost();
        $purchase_id = $data['id'];

        $purchase_model = model('Purchase');
        $purchase_detail_model = model('PurchaseDetail');
        $product_model = model('Product');

        $purchase = $purchase_model->find($purchase_id);

        // return response()->setJSON($data);

        if (isset($data['status']) && $data['status'] == 'Done') {

            // UPDATE DATA PRODUCT STOCK FROM PURCHASE ORDER
            $purchase_detail = $purchase_detail_model->where('purchase_id', $purchase_id)->findAll();

            foreach ($purchase_detail as $detail) {

                $product_id = $detail['product_id'];
                $new_quantity = $detail['quantity'];

                $current_product = $product_model->find($product_id);
                // DO UPDATE STOCK IF FOUNDED
                if ($current_product) {

                    $new_product_data = [
                        'stock' => $current_product['stock'] + $new_quantity,
                    ];

                    $product_model->update($current_product['id'], $new_product_data);
                }
            }

            // UPDATE DATA PURCHASE
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $purchase_model->update($purchase['id'], $data);

            session()->setFlashdata('alert', ['message' => 'Successfully update purchase and product stock.', 'variant' => 'alert-success']);
            return redirect()->back();
        } else {
            // UPDATE DATA PURCHASE
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $purchase_model->update($purchase['id'], $data);

            session()->setFlashdata('alert', ['message' => 'Successfully updated.', 'variant' => 'alert-success']);
            return redirect()->back();
        }
    }
}
