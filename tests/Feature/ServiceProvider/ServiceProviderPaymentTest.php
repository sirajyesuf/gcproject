<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceProviderPaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_payment_method_with_out_data()
    {
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/add_payment');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_add_payment_method_with_valid_data()
    {   
        $data = [
            'account_number'=>38573489573489758,
            'account_holder'=>'Jemal Yesuf',
            'payment_method'=>1
        ];
        $serviceProvider = ServiceProvider::find(110);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/add_payment',$data);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('provider_payment_methods',$data);

    }

    public function test_add_payment_method_with_double_payment()
    {   
        $data = [
            'account_number'=>38573489548578934758934773489758,
            'account_holder'=>'Jemal Yesuf',
            'payment_method'=>1
        ];
        $serviceProvider = ServiceProvider::find(133);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/add_payment',$data);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_ACCEPTED);
    }
    
    public function test_edit_payment_method()
    {   
        $data = [
            'account_number'=>38573489573489758343434,
            'account_holder'=>'kemal Yesuf',
            'payment_method'=>1
        ];
        $serviceProvider = ServiceProvider::find(133);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/edit_payment_method/1',$data);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_edit_payment_method_with_invalid_data()
    {   
        
        $serviceProvider = ServiceProvider::find(133);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/edit_payment_method/1');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_get_payment_method()
    {   
        
        $serviceProvider = ServiceProvider::find(133);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/get_payment_method');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }
    
}
