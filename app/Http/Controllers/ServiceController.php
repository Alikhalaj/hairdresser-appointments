<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        if (request()->wantsJson()) {
            var_dump(request()->wantsJson());
            return response($services);
        }
        return view('service.index', compact('services'));
    }
    public function store()
    {
        $service = auth()->user()->services()->create(request()->validate([
            'time' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]));
        return response($service);
    }
    public function show(Service $service)
    {
        if (request()->wantsJson()) {
            return response($service);
        }
        return view('service.show', compact('service'));
    }
}
