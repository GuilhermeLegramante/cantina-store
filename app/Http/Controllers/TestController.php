<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function table()
    {
        return view('parent.test-table');
    }
}
