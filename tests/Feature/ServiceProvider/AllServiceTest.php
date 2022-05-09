<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetching()
    {
        $service_provider = ServiceProvider::find(8);
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/all_services');
        $response->dump();
        $response->assertStatus(200);
    }
}
