<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class BarberTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /** @test*/
    // //problem file
    public function a_user_create_barber()
    {
        Role::create(['name' => 'barber']);
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create(),'api');
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar2.jpg');
        $attribuites = [
            'name_shop'=>$this->faker->name(),
            'phone' =>$this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            'time_work_start'=>Carbon::now('Asia/Tehran')->format('H:i:s'),
            'time_work_end'=> Carbon::now('Asia/Tehran')->subHours(8)->format('H:i:s'),
            'image_business_license'=>$file,
            'image_hairdressing_degree'=>$file2,
            'latitude'=>$this->faker->latitude(25,39),
            'longitude'=>$this->faker->longitude(44,63),
            'suggest'=>0,
            'offer'=>0,
        ];
        $this->postJson('api/barber', $attribuites);
        $this->assertTrue(true);
        array_splice($attribuites,5,6);
        $this->assertDatabaseHas('barbers', $attribuites);
        $response = $this->getJson('api/barbers/index');
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
        Role::create(['name' => 'barber']);
        $this->actingAs(factory('App\User')->create(),'api');
        $attribuites = factory('App\Barber')->raw();
        $this->postJson('api/barber',  $attribuites)->assertSee('user');
    }
    /** @test */
    public function a_user_can_view_a_profile_barber()
    {
        $barber = factory('App\Barber')->create();
        $this->get('api/barber/' . $barber->id)->assertSee($barber->phone)->assertSee($barber->latitude)->assertSee($barber->time_work_end);
    }
}
