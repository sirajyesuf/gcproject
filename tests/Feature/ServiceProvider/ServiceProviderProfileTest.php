<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use App\Models\ServiceProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceProviderProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   
    public function test_with_out_authentication()
    {
        
        // $user = User::find(12);
        // $token = $user->createToken('test device')->plainTextToken;
        $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/profile');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_with_valid_data()
    {
        
        $serviceProvider = ServiceProvider::find(1);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/profile');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_edit_profile_with_out_authentication()
    {
        
        $serviceProvider = ServiceProvider::find(1);
        // $token = $serviceProvider->createToken('test device')->plainTextToken;
        $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/edit_profile');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_edit_profile_with_invalid_data()
    {
        
        $serviceProvider = ServiceProvider::find(1);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/edit_profile');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_edit_profile_with_valid_data()
    {
        
        $fields = [
            'phone_number'=>'251917328980',
            'owner_name'=>'hasen',
            'business_name' => 'jemal spa spa',
            'latitude' =>9.033140,
            'longitude'=>38.750080,
            'logo'=>UploadedFile::fake()->image('hasen.jpg'),
            'type'=>1
        ];
        $serviceProvider = ServiceProvider::find(1);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
                         ->postJson('/service_provider/edit_profile',$fields);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_log_out()
    {
        $serviceProvider = ServiceProvider::find(1);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/log_out');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
