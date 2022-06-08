<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

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
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/profile');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_one()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/profile');
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_log_out()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/log_out');
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_edit_profile()
    {
        $data = [
            'name'=>'kebede ahmed',
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_profile',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_edit_profile_phone_number()
    {
        $data = [
            'phone_number'=>'ahmed kemal ahmed',
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_profile',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_edit_profile_phone_number_one()
    {
        $data = [
            'phone_number'=>'251994920166',
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_profile',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_edit_profile_picture()
    {
        $data = [
            'profile_picture'=> UploadedFile::fake()->image('kemal_muhammed.jpg'),
        ];
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_profile',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }
}
