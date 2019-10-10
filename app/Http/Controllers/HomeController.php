<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->check()) {
            return redirect('admin-dashboard');
        }else{
            return view('auth.login');
        }
    }

    public function get_country_code(Request $request)
    {
        if($request->isMethod('post'))
        {
            $country = Country::where('name',$request->id)->first();
            return response()->json($country);
        }
    }
}
