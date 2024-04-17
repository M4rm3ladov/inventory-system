<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index() {
        return view('product.category');
    }
}
