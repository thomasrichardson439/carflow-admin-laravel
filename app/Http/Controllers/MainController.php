<?php

namespace App\Http\Controllers;

use App\Models\Borough;
use App\Models\CarCategory;
use App\Models\CarManufacturer;
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
        return view('main/register_car',[
            'carCategories' => CarCategory::all(),
            'carManufacturers' => CarManufacturer::all(),
            'boroughs' => Borough::all(),
        ]);
    }
    public function register_driver()
    {
        $data['defaultApps'] = ['Uber','Lyft','Via','Juno','Gett','Other'];
        return view('main/register_driver', $data);
    }
    public function welcome()
    {
        return view('main/welcome');
    }
}
