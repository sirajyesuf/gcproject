<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class checkPhoneNumberExistenceTest extends TestCase
{
    /**
     * phone number not exist test
     *
     * @return void
     */
    public function test_check_phone_number_is_not_exist()
    {
        $phone_number = '0994920163';
        $response = $this->postJson('/user/check_phone_number_existence',['phone_number'=>$phone_number]);

        $response->assertStatus(200)
                 ->assertExactJson(['is_exist'=>false]);
    }
    /**
     * phone number validation existence test
     *
     * @return void
     */
    public function test_phone_number_is_exist()
    {
        $phone_number = '+1-858-732-1025';
        $response = $this->postJson('/user/check_phone_number_existence',['phone_number'=>$phone_number]);
        $response->dump();
        $response->assertStatus(200)
                 ->assertExactJson(['is_exist'=>true]);
    }
}
