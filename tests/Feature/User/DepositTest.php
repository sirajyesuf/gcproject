<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class DepositTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_deposit_one()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/deposit/0');
        $response->dump();
        $response->assertStatus(422);
    }

    public function test_deposit_two()
    {
        $data = [
            'amount'=>100,
            'payment_method' => 1,
            'transaction_number'=>'dkjlfjasklfjklasjklfj'
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/deposit/0',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_deposit_three()
    {
        // $user = User::find(1);
        $token = 'jkdfksljlskdjfklsjdklfj';
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/deposit/0');
        $response->dump();
        $response->assertStatus(401);
    }


}
