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
        $date = $this->request->getGet('date');

        $purchase_model = model('Purchase');

        $purchase_column = db_connect()->getFieldData('purchases');
        $purchases = $purchase_model
            ->when($filter, static function ($query, $filter) {
                $query
                    ->orLike('id', "%{$filter}%")
                    ->orLike('name', "%{$filter}%")
                    ->orLike('stock', "%{$filter}%");
            })
            ->when($date, static function ($query, $date) {
                $query->where('date', $date);
            })
            ->findAll();

        $date = $purchase_model->findColumn('created_at');
        $created_at = [];

        foreach ($date as $d) {
            array_push($created_at, Carbon::create($d)->format('d/m/y'));
        }
        return view('purchase/home', [
            'purchase_column' => $purchase_column,
            'purchases' => $purchases,
            'created_at' => $created_at,
            'email' => $purchase_model->findColumn('admin_email'),
            'total' => $purchase_model->findColumn('total'),
        ]);
    }
}
