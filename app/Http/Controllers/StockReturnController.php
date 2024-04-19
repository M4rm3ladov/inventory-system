<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockReturnController extends Controller
{
    public function index() {
        return view('product-stock.stock-return');
    }
}
