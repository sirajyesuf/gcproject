<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use App\Models\ServiceProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_with_out_authentication()
    {
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/add_service');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_with_out_data()
    {
        // Sanctum::actingAs();
        $service_provider = ServiceProvider::factory()->create();
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/add_service');
        $response->dump();
        $response->assertJson([
              "name"=> [
                0 => "The name field is required."
              ],
              "description"=> [
                0 => "The description field is required."
              ],
              "price"=> [
                0 => "The price field is required."
              ],
              "type"=> [
                0 => "The type field is required."
              ],
              
              "image"=> [
                0 => "The image field is required."
              ]
              ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_with_invalid_data()
    {
        $data = [
            'name'=>'hasen',
            'description'=>'haasen suadil',
            'type'=>-1,
            'image'=>'image',
        ];
        // Sanctum::actingAs(ServiceProvider::factory()->create());
        $service_provider = ServiceProvider::factory()->create();
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/add_service',$data);
        $response->dump();
        $response->assertJson([
              "type"=> [
                 0 => 'The selected type is invalid.',              
                ],
            
              "image"=> [
                 0 => 'The image must be an image.',          
                     ]
              ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_with_valid_data()
    {
        $data = [
            'name'=>'suri',
            'description'=>'haasen suadil',
            'type'=>1,
            'image'=>UploadedFile::fake()->image('hasen.jpg'),
            'price'=>10
        ];
        $service_provider = ServiceProvider::factory()->create();
        $token = $service_provider->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/add_service',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_CREATED);
    }
}
