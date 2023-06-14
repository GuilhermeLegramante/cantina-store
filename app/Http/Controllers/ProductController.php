<?php

namespace App\Http\Controllers;

class ProductController extends Controller
{
    public function table()
    {
        return view('parent.product-table');
    }
}
