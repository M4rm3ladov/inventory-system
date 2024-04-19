<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function index() {
        return view('product-stock.stock-in');
    }
}
