<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_edit()
    {
        $data = [
            'name'=>'suri',
            'description'=>'sheikh jemal muhammed',
            'type'=>1,
            'image'=>UploadedFile::fake()->image('jemal.jpg'),
            'price'=>40
        ];
        $service_provider = ServiceProvider::find(8);
        $service = Service::where('service_provider_id',$service_provider->id)->first();
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
        ->postJson('/service_provider/edit_service/'.$service->id,$data);
        $response->dump();
        $response->assertStatus(200);
    }
}
