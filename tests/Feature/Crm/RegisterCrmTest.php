<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class RegisterCrmTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_admin_register_employe()
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPersonalAccessClient(
            null, 'Crm', '/'
        );
        $atrr=['first_name'=>'ehsan', 'last_name'=>'katebi','email'=>'ek.82@email.com','password'=>'123456'];
        $this->json('POST','/crm/register',$atrr,['Accept' => 'application/json'])->assertStatus(200)->assertJsonStructure(['token']);
        $this->assertTrue(true);
    }
}
