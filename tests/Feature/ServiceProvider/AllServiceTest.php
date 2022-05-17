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
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
        ->get('/service_provider/all_services');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_delete_service_unauthenticated()
    {
        $response = $this->withHeaders(['Accept'=>'application/json'])
        ->get('/service_provider/delete_service/10');
        $response->dump();
        $response->assertStatus(401);

    }

    public function test_delete_service_not_found()
    {
        $service_provider = ServiceProvider::find(8);
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
        ->get('/service_provider/delete_service/900');
        $response->dump();
        $response->assertStatus(404);

    }

    public function test_delete_service_success()
    {
        $service_provider = ServiceProvider::find(8);
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
        ->get('/service_provider/delete_service/1');
        $response->dump();
        $response->assertStatus(200);

    }

    
}
