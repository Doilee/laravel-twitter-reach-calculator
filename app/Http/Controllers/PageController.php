<?php

namespace App\Http\Controllers;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function welcome() : \Illuminate\View\View
    {
        return view('welcome');
    }
}
