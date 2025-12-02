<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        flash()->success('با موفقیت وارد شدی!!!');
        return view('admin.index');
    }
}
