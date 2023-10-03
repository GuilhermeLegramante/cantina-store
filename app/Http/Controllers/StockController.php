<?php

namespace App\Http\Controllers;

class StockController extends Controller
{
    public function table()
    {
        return view('parent.stock-table');
    }
}
