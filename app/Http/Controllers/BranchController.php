<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index() {
        return view('branch.branch', [
            'branches' => Branch::orderBy('created_at', 'DESC')->get()
        ]);
    }
 // return redirect()->route('branch.branch')->with('success', 'Branch created successfully!');
}
