<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_with_empty_input()
    {
       

        $response = $this->withHeader('Accept','application/json')->post('/user/register',[]);
        $response->dump();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_with_phone_number_is_exist()
    {   
        $fields = ['name'=>'hasen suadik','phone_number'=>'251994920163'];
        $response = $this->withHeader('Accept','application/json')->postJson('/user/register',$fields);
        $response->dump();
    }

      /**
     * test registration.
     *
     * @return void
     */
    public function test_registration()
    {   
        $fields = ['name'=>'Tesfaye Gobena','phone_number'=>'251923065851'];
        $response = $this->withHeader('Accept','application/json')->postJson('/user/register',$fields);
        $response->dump();
        $response->assertStatus(200)->assertExactJson([
            'sent'=>'message sent',
            'status'=>'success',
        ]);
    }

       /**
     * test code verification.
     *
     * @return void
     */
    public function test_code_verification()
    {   
        $fields = ['device_name'=>'Tesfaye Gobena','phone_number'=>'251940204832','code'=>473429];
        $response = $this->withHeader('Accept','application/json')->postJson('/user/verify_code',$fields);
        $response->dump();
        $response->assertStatus(200);
    }


     /**
     * test resend code.
     *
     * @return void
     */
    public function test_resend_code()
    {   
        $fields = ['phone_number'=>'251927366785'];
        $response = $this->withHeader('Accept','application/json')->postJson('/user/resend_code',$fields);
        // $response->dump();
        $response->assertStatus(200)->assertExactJson([
            'sent'=>'message sent',
            'status'=>'success',
        ]);
    }

     /**
     * test registration.
     *
     * @return void
     */
    public function test_login()
    {   
        $fields = ['phone_number'=>'251940204832','code'=>473429,'device_name'=>'tekno'];
        // $user = User::where('phone_number','251927366785')->first();
        // $token = $user->createToken('tekno')
        $response = $this->withHeader('Accept','application/json')->post('/user/login',$fields);
        // $response->dump();
        $response->dump();

        $response->assertStatus(200);
    }
}
