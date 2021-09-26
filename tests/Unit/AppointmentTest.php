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
    use WithFaker;
    /**
     * @test
     */
    // public function check_time_interference()
    // {
    //     $start = Carbon::create('2021-03-23  10:48:34');
    //     $end = Carbon::create($start)->addMinutes(20);
    //     $appointment = Appointment::where('barber_id', 1)->whereDate('time_start', '=', '2021-03-23')->get();
    //     foreach ($appointment as $appoint) {
    //         var_dump($appoint);
    //         if ($start >= $appoint->time_start && $start <= $appoint->time_end || $end >= $appoint->time_start && $end <= $appoint->time_end ) {
    //             $this->assertTrue(true);
    //         }
    //     }
    //     // $this->assertTrue(true);
    // }
}
