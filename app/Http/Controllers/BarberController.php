<?php

namespace App\Http\Controllers;

use App\Barber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberController extends Controller
{
    public function index($barber)
    {
        if ($barber == 'index') {
            $barbers = Barber::all();
            if (request()->wantsJson()) {
                var_dump(request()->wantsJson());
                return response($barbers);
            }
        } elseif ($barber == 'suggest') {
            $barbers = Barber::where('suggest', '1')->get();
            return response($barbers);
        } elseif ($barber == 'offer') {
            $barbers = Barber::where('offer', '1')->get();
            return response($barbers);
        }
    }
    public function edit(Request $request)
    {
        $attribuites = request()->validate([
            'name_shop'=>'required',
            'phone' => 'required',
            'address' => 'required',
            'time_work_start' => 'required',
            'time_work_end' => 'required',
            'image_business_license' => 'required|mimes:png|max:2048',
            'image_hairdressing_degree' => 'required|mimes:png|max:2048',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        $barber = Auth::user()->barber()->update($attribuites);
        // $barber->assignRole('Barber');
        return response($barber);
    }
    public function store(Request $request)
    {
        $attribuites = request()->validate([
            'name_shop'=>'required',
            'phone' => 'required',
            'address' => 'required',
            'time_work_start' => 'required',
            'time_work_end' => 'required',
            'image_business_license' => 'required|mimes:png|max:2048',
            'image_hairdressing_degree' => 'required|mimes:png|max:2048',
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
            return response( Auth::user()->barber);
        }
        return view('service.show', compact('service'));
    }

    public function search()
    {
        try {
            $attribuites = request()->validate(['phone' => 'required']);
            $attribuites = request()->input("phone");
            $barber = Barber::query()->where('phone', 'LIKE', "%{$attribuites}%")->get();
            return response($barber);
        } catch (Exception $e) {
            return response($e->getMessage());
        }
    }
}
