<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WithDrawTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ask_withdraw_with_out_data()
    {   
        
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/withdraw_request');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_ask_withdraw_with_large_amount()
    {   
        $data = [
            'amount'=>20000
        ];
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/withdraw_request',$data);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_ask_withdraw_with_fair_amount()
    {   
        $data = [
            'amount'=>10000
        ];
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/withdraw_request',$data);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_ask_withdraw_again()
    {   
        $data = [
            'amount'=>10000
        ];
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/service_provider/withdraw_request',$data);
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_data()
    {   
        $data = [
            'amount'=>10000
        ];
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/withdraw_data/1');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_withdraws()
    {   
        $data = [
            'amount'=>10000
        ];
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/withdraws');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
