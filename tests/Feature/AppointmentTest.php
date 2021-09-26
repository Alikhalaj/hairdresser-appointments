<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AppointmentTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_useer_set_appointment()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $start = Carbon::create($this->faker->dateTimeBetween('-1 years', now(), 'Asia/Tehran'))->minute(0)->second(0);
        $service = $this->faker->numberBetween(2,6) * 5;
        $price = $this->faker->numberBetween(1, 10) * 10000;
        $barber =factory('App\Barber')->create();
        $detail = [
            'barber_id' => "{$barber->id}",
            'price' => "{$price}",
            'prepayment' => $price * 0.05,
            'time' => "{$start}",
            'time_service' => "{$service}"
        ];
        $response = $this->postJson('api/appointment', $detail);
        // $response->assertJson($detail);
        $this->assertDatabaseHas('appointments', ['barber_id' => $barber->id]);
        $response = $this->getJson('api/appointments');
        $response
            ->assertStatus(200)
            ->assertSee($detail['barber_id'])
            ->assertSee($detail['prepayment'])
            ->assertSee($detail['price']);
    }
}
