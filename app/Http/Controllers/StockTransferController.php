<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockTransferController extends Controller
{
    public function index() {
        return view('product-stock.stock-transfer');
    }
}
