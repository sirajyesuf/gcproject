<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class BookingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_booking_with_out_authentication()
    {
        // $user = User::find(1);
        $token = "kdfjklsdjfkldjsklf";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book');
        $response->dump();
        $response->assertStatus(401);
    }

    public function test_booking_with_out_valid_data()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book');
        $response->dump();
        $response->assertStatus(422);
    }

    public function test_booking_with_invalid_date()
    {
        $data = [
            'service_date'=>'dskfjsdk',
            'service_id' => 1
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book',$data);
        $response->dump();
        $response->assertStatus(422);
    }
    public function test_booking_with_old_date()
    {
        $data = [
            'service_date'=>'2021-10-22',
            'service_id' => 1
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book',$data);
        $response->dump();
        $response->assertStatus(422);
    }


    public function test_booking_with_non_existent_id()
    {
        $data = [
            'service_date'=>'2022-10-22',
            'service_id' => 1000
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book',$data);
        $response->dump();
        $response->assertStatus(422);
    }

    public function test_booking_with_insufficient_balance()
    {
        $data = [
            'service_date'=>'2022-10-22',
            'service_id' => 1
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book',$data);
        $response->dump();
        $response->assertStatus(202);
    }

    public function test_booking_with_valid_data()
    {
        $data = [
            'service_date'=>'2022-10-22',
            'service_id' => 1
        ];
        $user = User::find(15);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/book',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_eligibility()
    {
        
        $user = User::find(12);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/check_booking_eligibility/1');
        $response->dump();
        $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }
    
}
