<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    return view('home', [
        'featuredItems' => MenuItem::take(3)->get()
    ]);
}
}
