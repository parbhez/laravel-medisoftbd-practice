<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function index()
    {
    	return  str_singular('category');
    }
}
