<?php

namespace App\Http\Controllers;

use App\Support\Products;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'products' => Products::all(),
        ]);
    }

    public function policy(): View
    {
        return view('pages.policy');
    }

    public function agreement(): View
    {
        return view('pages.agreement');
    }

    public function offer(): View
    {
        return view('pages.offer');
    }
}