<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ListOfServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_of_service_one()
    {
        $latitude  =  8.563664258393274;
        $longitude =  39.29194623894618;
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/services/'.$latitude.'/'.$longitude);
        $response->dump();
        
        
        $response->assertStatus(200);
    }

    public function test_list_of_service_two()
    {
        $latitude  =  8.563664258393274;
        $longitude =  39.29194623894618;
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/services/'.$latitude.'/'.$longitude);
        $response1 = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('http://gcproject.test/user/services/8.5636642583933/39.291946238946?page=2');

        $response->dump();
        $response1->dump();
        $response->assertStatus(200);

        // $new_response = json_decode($response);
        
        $response1->assertStatus(200);
    }


    public function test_list_of_service_three()
    {
        $latitude  =  8.563664258393274;
        $longitude =  39.29194623894618;
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json'])->get('/user/services/'.$latitude.'/'.$longitude);
        $response1 = $this->withHeaders(['Accept'=>'application/json'])->get('http://gcproject.test/user/services/8.5636642583933/39.291946238946?page=2');

        $response->dump();
        $response1->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        // $new_response = json_decode($response);
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    }


}
