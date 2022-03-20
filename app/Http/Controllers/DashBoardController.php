<?php

namespace App\Http\Controllers;
use Session;
class DashBoardController extends Controller
{
    public function index()
    {
        return view('login');
    }
}
