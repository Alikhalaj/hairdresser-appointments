<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BarberTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /** @test*/
    public function a_user_create_barber()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = [
            'phone' =>$this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            'time_work_start'=>Carbon::now('Asia/Tehran')->format('H:i:s'),
            'time_work_end'=> Carbon::now('Asia/Tehran')->subHours(8)->format('H:i:s'),
            'image_business_license'=>"C:\Users\AKH\AppData\Local\Temp\481e787bb24b3b0620cadb7453186433.png",
            'image_hairdressing_degree'=>"C:\Users\AKH\AppData\Local\Temp\481e787bb24b3b0620cadb7453186433.png",
            'latitude'=>$this->faker->latitude(25,39),
            'longitude'=>$this->faker->longitude(44,63),
        ];
        $this->postJson('api/barber', $attribuites);
        $this->assertDatabaseHas('barbers', $attribuites);
        $response = $this->getJson('api/barbers');
        $response
            ->assertStatus(200)
            ->assertSee($attribuites['phone']);
    }
    /** @test */
    public function a_barber_requiers_time_work_end()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Barber')->raw(['time_work_end' => '']);
        $this->postJson('api/barber', $attribuites)->assertJsonValidationErrors('time_work_end');
    }
    /** @test */
    public function a_barber_requiers_time_work_start()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Barber')->raw(['time_work_start' => '']);
        $this->postJson('api/barber', [])->assertJsonValidationErrors('time_work_start');
    }
    /** @test */
    public function a_barber_requiers_phone()
    {
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Barber')->raw(['phone'=>'']);
        $this->postJson('api/barber', $attribuites)->assertJsonValidationErrors('phone');
    }
    /** @test */
    public function test(){
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Barber')->raw();
        $this->postJson('api/barber',  $attribuites)->assertSee('user_id');
    }
    /** @test */
    public function a_user_can_view_a_profile_barber()
    {
        $barber = factory('App\Barber')->create();
        $this->get('api/barber/' . $barber->id)->assertSee($barber->phone)->assertSee($barber->latitude)->assertSee($barber->time_work_end);
    }
}
