<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user()
    {
        $token="sdfjklsdjfklsdjklfj";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/find_user/1');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_one()
    {
        $user = User::find(12);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/find_user/1');
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }
}
