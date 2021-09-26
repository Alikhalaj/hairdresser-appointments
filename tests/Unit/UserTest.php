<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_has_services()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->services);
    }
    /** @test */
    public function a_user_has_barbers()
    {
        $user = factory('App\User')->create();
        
        $this->assertInstanceOf(Collection::class, $user->barber);
    }
    /** @test */
    public function a_user_has_appointments()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->appointments);
    }
}
