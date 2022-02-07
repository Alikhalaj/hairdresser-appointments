<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /** @test */
    public function a_barber_create_service()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = [
            'time' => $this->faker->numberBetween(1, 4) * 5,
            'name' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1, 10) * 1000
        ];
        $this->postJson('api/service', $attribuites);
        $this->assertDatabaseHas('services', $attribuites);
        $response = $this->getJson('api/services');
        $response
            ->assertStatus(200)
            ->assertSee($attribuites['name']);
        $this->get('/services')->assertSee($attribuites['name']);
    }
    /** @test */
    public function a_service_requiers_time()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Service')->raw(['time' => '']);
        $this->postJson('api/service', $attribuites)->assertJsonValidationErrors('time');
    }
    /** @test */
    public function a_service_requiers_name()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Service')->raw(['name' => '']);
        $this->postJson('api/service', $attribuites)->assertJsonValidationErrors('name');
    }
    /** @test */
    public function a_service_requiers_price()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Service')->raw(['price' => '']);
        $this->postJson('api/service', $attribuites)->assertJsonValidationErrors('price');
    }
    /** @test */
    public function a_service_requiers_a_barber()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Service')->raw();
        $this->postJson('api/service',  $attribuites)->assertSee('barber_id');
    }
    /** @test */
    public function a_barber_can_view_a_service()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create(),'api');
        $service = factory('App\Service')->create();
        $this->get('service/' . $service->id)->assertSee($service->name)->assertSee($service->time)->assertSee($service->price);
        $this->get('api/service/' . $service->id)->assertSee($service->name)->assertSee($service->time)->assertSee($service->price);
    }
}
