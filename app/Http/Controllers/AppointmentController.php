<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Barber;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        if (request()->wantsJson()) {
            var_dump(request()->wantsJson());
            return response($appointments);
        }
        return view('appointments.index', compact('appointments'));
    }
    public function store()
    {
        $attribuites = request()->validate([
            'barber_id' => 'required',
            'price' => 'required',
            'prepayment' => 'required',
            'time' => 'required',
            'time_service' => 'required',
        ]);
        try {
            $last = $this->lastTime($attribuites['time'], $attribuites['barber_id']);
            $time_start = Carbon::create($last)->addSeconds(1)->format('Y-m-d H:i:s');
            $time_end = Carbon::create($last)->addMinutes($attribuites['time_service'])->format('Y-m-d H:i:s');
            if ($this->check($attribuites['time'], $time_start, $time_end, $attribuites['barber_id'])) {
                $appointment = Auth::user()
                    ->appointments()
                    ->create([
                        'barber_id' => $attribuites['barber_id'],
                        'time_start' => $time_start,
                        'time_end' => $time_end,
                        'price' => $attribuites['price'],
                        'prepayment' => $attribuites['prepayment']
                    ]);
                return response($appointment);
            }
            return "قرار ملاقات شما پرشده است یا با ملاقات دیگر تداخل دارد";
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function show(Appointment $appointment)
    {
        if (request()->wantsJson()) {
            return response($appointment);
        }
        return view('appointment.show', compact('appointment'));
    }

    public function lastTime($time, $barber)
    {
        $time = Carbon::create($time);
        $appointment = Appointment::where('barber_id', $barber)
            ->whereDate('time_start', '=', $time->format('Y-m-d'))
            ->whereTime('time_start', '>=', $time->format('H:i:s'))
            ->whereTime('time_start', '<', $time->addHours(1))
            ->orderByDesc('time_end')->get();
        var_dump($appointment);
        if (!$appointment->isEmpty()) {
            return $appointment[0]->time_end;
        } else {
            return $time;
        }
    }

    public function check($time, $time_start, $time_end, $barber)
    {
        $date = Carbon::create($time_start);
        $appointment = Appointment::where('barber_id', $barber)->whereDate('time_start', '=', $date->format('Y-m-d'))->get();
        foreach ($appointment as $appoint) {
            if ($time_start >= $appoint->time_start && $time_start <= $appoint->time_end || $time_end >= $appoint->time_start && $time_end <= $appoint->time_end || Carbon::create($time_start) >= Carbon::create($time)->addHours(1)) {
                return false;
            }
        }
        return true;
    }
}
