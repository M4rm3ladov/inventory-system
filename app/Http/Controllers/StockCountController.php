<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockCountController extends Controller
{
    public function index() {
        return view('product-stock.stock-count');
    }
}
