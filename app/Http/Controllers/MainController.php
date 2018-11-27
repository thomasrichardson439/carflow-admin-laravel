<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('main/landing');
    }
    public function drivers()
    {
        return view('main/drivers');
    }
    public function owners()
    {
        return view('main/owners');
    }
    public function how_it_works()
    {
        return view('main/how_it_works');
    }
    public function about_us()
    {
        return view('main/about_us');
    }
    public function faq()
    {
        return view('main/faq');
    }
    public function register_car()
    {
        return view('main/register_car');
    }
    public function register_driver()
    {
        return view('main/register_driver');
    }
    public function welcome()
    {
        return view('main/welcome');
    }
}
