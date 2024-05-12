<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Carbon\Carbon;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class PurchaseController extends BaseController
{
    public function index()
    {
        $filter = $this->request->getGet('filter');
        $start_date = $this->request->getGet('start_date') ?? Carbon::now()->addDays(-30);
        $end_date = $this->request->getGet('end_date') ?? Carbon::now()->toDateString();
        $date = [
            $start_date,
            $end_date,
        ];

        $purchase_model = model('Purchase');
        $purchase_column = db_connect()->getFieldData('purchases');
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
            // ->where("created_at BETWEEN '$start_date' AND '$end_date'")
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

        // return response()->setJSON($admin);

        return view('purchase/home', [
            'purchase_column' => $purchase_column,
            'purchases' => $purchases,
            'created_at' => $created_at,
            'admin' => $admin,
            'total' => $total,
        ]);
    }

    public function purchaseDetail($purchase_id)
    {
        $purchase = db_connect()->table('purchase_details')->where('purchase_id', $purchase_id)->get()->getResultObject();

        if ($purchase) {
            return response()->setJSON($purchase);
        } else {
            session()->setFlashdata('modal', ['message' => 'Purchase not found.']);
            return redirect()->back();
        }
    }
}
