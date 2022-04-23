<?php

namespace Tests\Feature\ServiceProvider;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class AuthenticationTest extends TestCase
{
    /**
     * test /service_provider/check_phone_number_existence end point
     * with phone number that is not found on the database
     *
     * @return void
     */
    public function test_phone_number_existence_one()
    {
        $fields = ['phone_number'=>'251994920163'];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/check_phone_number_existence',$fields);
        $response->dump();
        $response->assertJsonStructure([
            'is_exist'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'is_exist'=>false
        ]);
    }

    /**
     * test /service_provider/check_phone_number_existence end point
     * with out phone number 
     *
     * @return void
     */

    public function test_phone_number_existence_two()
    {
        // $fields = ['phone_number'=>'251994920163'];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/check_phone_number_existence');
        $response->dump();
        $response->assertJsonStructure([
            "phone_number"=>[
              0
            ]
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "phone_number"=>[
              0 => "please insert your phone number"
            ]
        ]);
    }


     /**
     * test /service_provider/check_phone_number_existence end point
     * with invalid format phone number not start 251
     *
     * @return void
     */

    public function test_phone_number_existence_three()
    {
        $fields = ['phone_number'=>'351994920163'];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/check_phone_number_existence',$fields);
        $response->dump();
        $response->assertJsonStructure([
            "phone_number"=>[
              0
            ]
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "phone_number"=>[
              0 => "phone number must start with 251"
            ]
        ]);
    }

    /**
     * test /service_provider/check_phone_number_existence end point
     * with invalid format phone number length 
     *
     * @return void
     */

    public function test_phone_number_existence_four()
    {
        $fields = ['phone_number'=>'2519949201633'];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/check_phone_number_existence',$fields);
        $response->dump();
        $response->assertJsonStructure([
            "phone_number"=>[
              0
            ]
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "phone_number"=>[
              0 => "length of the phone number must be 9 with out country code"
            ]
        ]);
    }

    /**
     * test /service_provider/check_phone_number_existence end point
     * with phone number that is already found on the database
     *
     * @return void
     */
    public function test_phone_number_existence_five()
    {
        $fields = ['phone_number'=>'251994920163'];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/check_phone_number_existence',$fields);
        $response->dump();
        $response->assertJsonStructure([
            'is_exist'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'is_exist'=>true
        ]);
    }

    /**
     * test /service_provider/register end point
     * with out giving any data
     *
     * @return void
     */
    public function test_registration_one()
    {
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/register');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson( [
            "phone_number" => [
              0 => "The phone number field is required."
            ],
            "business_name"=> [
              0 => "The business name field is required."
            ],
            "owner_name"=> [
              0 => "The owner name field is required."
            ],
            "latitude"=> [
              0 => "The latitude field is required."
            ],
            "longitude"=> [
              0 => "The longitude field is required."
            ],
            "logo"=> [
              0 => "The logo field is required."
            ],
            "type"=> [
              0 => "The type field is required."
            ],
        ]);
    }


    /**
     * test /service_provider/register end point
     * with invalid format data
     *
     * @return void
     */
    public function test_registration_two()
    {
        $fields = [
            'phone_number'=>'2519999',
            'owner_name'=>'hasen',
            'business_name' => 'hasen spa',
            'latitude' => 'hasen suadik',
            'longitude'=>'hasen suadik',
            'logo'=>'rebu',
            'type'=>'hasne'
        ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/register',$fields);
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson( [
            "phone_number" => [
              0 => "length of the phone number must be 9 with out country code"
            ],
            "latitude"=> [
              0 => "The latitude format is invalid."
            ],
            "longitude"=> [
              0 => "The longitude format is invalid."
            ],
            "logo"=> [
              0 => "The logo must be an image."
            ],
            "type"=> [
              0 => "The type must be an integer.",
              1=> "The selected type is invalid."
            ],
        ]);
    }

    /**
     * test /service_provider/register end point
     * with full data
     *
     * @return void
     */
    public function test_registration_three()
    {
        $fields = [
            'phone_number'=>'251994920163',
            'owner_name'=>'hasen',
            'business_name' => 'hasen spa',
            'latitude' =>9.033140,
            'longitude'=>38.750080,
            'logo'=>UploadedFile::fake()->image('hasen.jpg'),
            'type'=>1
        ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/register',$fields);
        $response->dump();
        $response->assertStatus(Response::HTTP_CREATED);
        
    }

     /**
     * test /service_provider/login end point
     * with invalid code
     *
     * @return void
     */
    public function test_login_one()
    {
        $fields = [
            'phone_number'=>'251994920163',
            'code'=>7688,
            'device_name'=>'tecno'
        ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/login',$fields);
        $response->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson([
            'status'=>'fail',
            'message'=>'invalid or expired code'
        ]);
        
    }

     /**
     * test /service_provider/login end point
     * with out data
     *
     * @return void
     */
    public function test_login_two()
    {
        
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/login');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "phone_number"=>[
              0 => "please send  phone number"
            ],
            "code"=> [
              0 => "please send your code"
            ],
            "device_name"=>[
              0 => "device name is required"
            ]
        ]);
        
    }

    /**
     * test /service_provider/login end point
     * with valid code
     *
     * @return void
     */
    public function test_login_three()
    {
        $fields = [
            'phone_number'=>'251994920163',
            'code'=>157545,
            'device_name'=>'tecno'
        ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/login',$fields);
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
        
        
    }

     /**
     * test /service_provider/resend_code end point
     * with out data
     *
     * @return void
     */
    public function test_resend_code_one()
    {
        // $fields = [
        //     'phone_number'=>'251994920163',
        //     'code'=>157545,
        //     'device_name'=>'tecno'
        // ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/resend_code');
        $response->dump();
        $response->assertJson([
            'phone_number'=>[
                0=>'please send  phone number'
            ]
            ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);   
    }

     /**
     * test /service_provider/resend_code end point
     * with phone number
     *
     * @return void
     */
    public function test_resend_code_two()
    {
        $fields = [
            'phone_number'=>'251994920163',
        ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/resend_code',$fields);
        $response->dump();
        $response->assertJson([
            'sent'=>'message sent',
            'status'=>'success',
        ]);
        $response->assertStatus(Response::HTTP_OK);   
    }

         /**
     * test /service_provider/resend_code end point
     * with invalid format phone number
     *
     * @return void
     */
    public function test_resend_code_three()
    {
        $fields = [
            'phone_number'=>'25199492016',
        ];
        $response = $this->withHeader('Accept','application/json')->postJson('/service_provider/resend_code',$fields);
        $response->dump();
        $response->assertJson([
            'phone_number'=>[
                0=>'length of the phone number must be 9 with out country code'
            ]
            ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);   
    }
    

    

    



}
