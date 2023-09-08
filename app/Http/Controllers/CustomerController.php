<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    public function table()
    {
        return view('parent.customer-table');
    }
}
