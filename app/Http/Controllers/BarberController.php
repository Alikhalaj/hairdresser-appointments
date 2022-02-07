<?php

namespace App\Http\Controllers;

use App\Barber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Barber as BarberResources;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// 
class BarberController extends Controller
{
    // 'image_business_license' => 'required|mimes:png,jpg|max:2048',
    // 'image_hairdressing_degree' => 'required|mimes:png,jpg|max:2048',
    public function index($barber)
    {
        if ($barber == 'index') {
            $barbers = Barber::all();
        } elseif ($barber == 'suggest') {
            $barbers = Barber::where('suggest', '1')->get();
        } elseif ($barber == 'offer') {
            $barbers = Barber::where('offer', '1')->get();
        }
        return BarberResources::collection($barbers);
    }
    public function edit(Request $request)
    {
        $attribuites = request()->all();
        $barber = Auth::user()->barber;
        if (request()->input('phone') != $barber[0]->phone) {
            request()->validate([
                'phone' => 'unique:barbers',
            ]);
        }
        if (request()->input('image_business_license')) {
            request()->validate([
                'image_business_license' => 'mimes:png|max:2048',
            ]);
        }
        if (request()->input('image_business_license')) {
            request()->validate([
                'image_hairdressing_degree' => 'mimes:png|max:2048',
            ]);
        }
        if ($request->file('image_business_license')) {
            $image_business_license = $request->file('image_business_license')->store('public/Barber/License');
            $attribuites['image_business_license'] = $image_business_license;
        }
        if ($request->file('image_hairdressing_degree')) {
            $image_hairdressing_degree = $request->file('image_hairdressing_degree')->store('public/Barber/License');
            $attribuites['image_hairdressing_degree'] = $image_hairdressing_degree;
        }
        $barber = Auth::user()->barber()->update($attribuites);
        Auth::user()->assignRole('barber');
        return  response()->json(new BarberResources(Auth::user()->barber[0]), 200);
    }
    public function store(Request $request)
    {
        $role = Role::where('name', 'barber')->first();
        if (!isset($role)) {
            Role::create(['name' => 'barber']);
        }
        $attribuites = request()->validate([
            'name_shop' => 'required',
            'phone' => 'required|unique:barbers',
            'address' => 'required',
            'time_work_start' => 'required',
            'time_work_end' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'suggest' => 'required',
            'offer' => 'required',
        ]);
        if ($request->file('image_business_license') && $request->file('image_hairdressing_degree')) {
            $image_business_license = $request->file('image_business_license')->store('public/Barber/License');
            $image_hairdressing_degree = $request->file('image_hairdressing_degree')->store('public/Barber/Degree');
            $attribuites['image_business_license'] = $image_business_license;
            $attribuites['image_hairdressing_degree'] = $image_hairdressing_degree;

            $barber = Auth::user()->barber()->create($attribuites);
            Auth::user()->assignRole('barber');
            return response()->json(new BarberResources($barber), 200);
        }
    }
    public function profile()
    {
        return BarberResources::collection(Auth::user()->barber);
    }

    public function show(Barber $barber)
    {
        return  response()->json(new BarberResources($barber));
    }

    public function search()
    {
        try {
            $attribuites = request()->validate(['phone' => 'required']);
            $attribuites = request()->input("phone");
            $barber = Barber::where('phone', 'LIKE', "%{$attribuites}%")->orWhere('name_shop', 'LIKE', "%{$attribuites}%")->get();
            return BarberResources::collection($barber);
        } catch (Exception $e) {
            return response($e->message);
        }
    }
}
