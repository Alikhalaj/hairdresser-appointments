<?php

namespace App\Http\Controllers;

use App\Barber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberController extends Controller
{
    public function index($barber)
    {
        if($barber = 'index'){
            $barbers = Barber::all();
            if (request()->wantsJson()) {
                var_dump(request()->wantsJson());
                return response($barbers);
            }
        }elseif($barber = 'suggest'){
            $barbers = Barber::where('suggest','1')->get();
            return response($barbers);
        }elseif($barber = 'offer'){
            $barbers = Barber::where('offer','1')->get();
            return response($barbers);
        }
    }
    public function store(Request $request)
    {
        $attribuites = request()->validate([
            'phone' => 'required',
            'address' => 'required',
            'time_work_start' => 'required',
            'time_work_end' => 'required',
            'image_business_license' => 'required',
            'image_hairdressing_degree' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        $barber = Auth::user()->barber()->create($attribuites);
        // $barber->assignRole('Barber');
        return response($barber);
    }
    public function show(Barber $barber)
    {
        if (request()->wantsJson()) {
            return response($barber);
        }
        return view('service.show', compact('service'));
    }
}
