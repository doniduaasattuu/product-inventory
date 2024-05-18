<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Carbon\Carbon;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class SalesController extends BaseController
{
    private $categories;
    private $sales_column;

    public function __construct()
    {

        $this->sales_column = db_connect()->getFieldData('sales');
        $this->categories = model('Category')->findAll();
    }

    public function index()
    {
        $filter = $this->request->getGet('filter');
        $start_date = $this->request->getGet('start_date') ?? Carbon::now()->addDays(-30);
        $end_date = $this->request->getGet('end_date') ?? Carbon::now()->addDays(1)->toDateString();

        $sale_model = model('Sale');
        $sales = $sale_model
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
        foreach ($sales as $sale) {
            array_push($created_at, Carbon::create($sale['created_at'])->format('d/m/y'));
            array_push($admin, $user_table->where('email', $sale['admin_email'])->get()->getFirstRow()->name);
            array_push($total, $sale['total']);
        }

        return view('sales/home', [
            'sales_column' => $this->sales_column,
            'sales' => $sales,
            'created_at' => $created_at,
            'admin' => $admin,
            'total' => $total,
        ]);
    }

    public function salesDetail($sales_id)
    {
        $sales_details = db_connect()->table('sale_details')->where('sales_id', $sales_id)->get()->getResultArray();
        $sales = db_connect()->table('sales')->where('id', $sales_id)->get()->getFirstRow();

        if ($sales_details) {

            return view('sales/details', [
                'title' => 'Sales detail',
                'sales_id' => $sales_id,
                'sales' => $sales,
                'sales_details' => $sales_details,
                'sales_details_column' => db_connect()->getFieldData('sale_details'),
            ]);
        } else {
            session()->setFlashdata('modal', ['message' => 'Sales detail not found.']);
            return redirect()->back();
        }
    }

    public function salesDelete($sales_id)
    {
        $sales_table = db_connect()->table('sales');
        $sales_details_table = db_connect()->table('sale_details');

        $sales = $sales_table->where('id', $sales_id)->get()->getFirstRow();
        $sales_detail = $sales_details_table->where('sales_id', $sales_id)->get()->getResultObject();

        if ($sales) {

            // DELETE SALES DETAIL
            if (null != $sales_detail) {
                foreach ($sales_detail as $detail) {
                    $sales_details_table->delete(['sales_id' => $detail->sales_id]);
                }
            }

            // DELETE SALES
            $sales_table->delete(['id' => $sales->id]);
            session()->setFlashdata('modal', ['message' => 'Sales record successfully deleted.']);
            return redirect()->back();
        } else {
            session()->setFlashdata('modal', ['message' => 'Sales not found.']);
            return redirect()->back();
        }
    }

    public function salesNew()
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

        $sale_order = model('SaleOrder')->findAll();

        return view('sales/new', [
            'title' => 'New Sales',
            'product_column' => $product_column,
            'products' => $products,
            'categories' => $this->categories,
            'sale_order' => $sale_order,
        ]);
    }

    public function salesOrderAdd($product_id)
    {
        $product_model = model('Product');
        $product = $product_model->find($product_id);

        $product_exist = model('SaleOrder')->where('product_id', $product_id)->find();

        // return response()->setJSON($product_exist[0]);

        if ($product_exist) {

            $current_quantity = intval($product_exist[0]['quantity']);
            $new_quantity = $current_quantity + 1;

            $data = [
                'quantity' => $new_quantity,
            ];

            model('SaleOrder')->update($product_exist[0]['id'], $data);

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

                model('SaleOrder')->insert($data);

                session()->setFlashdata('alert', ['message' => "Product with id $product_id added to sales order.", 'variant' => 'alert-success']);
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('alert', ['message' => "Product wih id $product_id not found.", 'variant' => 'alert-danger']);
            return redirect()->back();
        }
    }

    public function salesOrder()
    {
        $db = db_connect();
        $sale_order_column = $db->getFieldData('sale_order');

        $sales_orders = model('SaleOrder')->findAll();

        return view('sales/order', [
            'title' => 'Sales order',
            'sale_order_column' => $sale_order_column,
            'sales_orders' => $sales_orders,
            'action' => '/sales-detail',
        ]);
    }

    public function salesOrderDeleteProduct($product_id)
    {
        model('SaleOrder')->where('product_id', $product_id)->delete();

        session()->setFlashdata('alert', ['message' => 'Successfully deleted.', 'variant' => 'alert-success']);
        return redirect('sales-order');
    }

    public function salesOrderDelete()
    {
        model('SaleOrder')->truncate();
        session()->setFlashdata('alert', ['message' => 'Sales order successfully deleted.', 'variant' => 'alert-info']);
        return redirect('sales-new');
    }

    public function salesDetailSubmit()
    {
        // return response()->setJSON($this->request->getPost());
        $data_request = $this->request->getPost('data');
        $total_request = $this->request->getPost('total');
        $sales_id = uniqid('sl_');

        $total = 0;
        $data = [];
        foreach ($data_request as $dt) {
            $dt['sales_id'] = $sales_id;
            $total += (int) $dt['sub_total'];

            array_push($data, $dt);
        }

        if ($total != $total_request) {
            session()->setFlashdata('alert', ['message' => 'Something wrong.', 'variant' => 'alert-warning']);
            return redirect()->back();
        }

        $db = db_connect();

        $db->transStart();
        $db->table('sales')->insert([
            'id' => $sales_id,
            'admin_email' => session()->get('user')->email,
            'total' => $total,
        ]);

        // return response()->setJSON($data);

        $db->table('sale_details')->insertBatch($data);
        $db->table('sale_order')->truncate();
        $db->transComplete();

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('modal', ['message' => 'Error occured.']);
            return redirect('sales');
        } else {
            session()->setFlashdata('modal', ['message' => 'Saved successfully.']);
            return redirect('sales');
        }
    }
}
