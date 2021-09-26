<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ServiceTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_a_patch():void
    {
        $service = factory('App\Service')->create();
        $this->assertEquals('/service/'.$service->id,$service->patch());
    }
}
