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

    public function store() {

        $branch = Branch::create([
            'name' => request()->get('name', ''),
            'address' => request()->get('address', ''),
            'email' => request()->get('email', ''),
            'phone' => request()->get('phone', ''),
        ]);

        // return redirect()->route('branch.branch')->with('success', 'Branch created successfully!');
    }
}
