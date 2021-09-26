<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class BarberTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_barber_has_appointments()
    {
        $barber = factory('App\Barber')->create();
        $this->assertInstanceOf(Collection::class, $barber->appointments);
    }
}
