<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListOfServicesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_of_service_one()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/services/38');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_list_of_service_two()
    {
        // $user = User::find(1);
        $token = "jkdfjklsdjfkljsdklfjklsdjfkljsd";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/services/38');
        $response->dump();
        $response->assertStatus(401);
    }
}
