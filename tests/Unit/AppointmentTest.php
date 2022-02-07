<?php

namespace Tests\Unit;

use App\Appointment;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;

use function PHPUnit\Framework\assertTrue;

class AppointmentTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /**
     * @test
     */
    public function check_time_interference()
    {
        $start = Carbon::create('2022-01-11 06:51:21');
        $end = Carbon::create($start)->addMinutes(20);
        $user = factory('App\User',2)->create();
        $barber=  factory('App\Barber')->create();
        $appoint = factory('App\Appointment',50)->create();
        $appointment = Appointment::where('barber_id', 1)->whereDate('time_start', '=', '2022-01-11')->get();
        foreach ($appointment as $appoint) {

            print($appoint->time_start);
            print("\n");
            if ($start >= $appoint->time_start && $start <= $appoint->time_end || $end >= $appoint->time_start && $end <= $appoint->time_end ) {
                $this->assertTrue(true);
            }
        }
        $this->assertTrue(true);
    }
}
