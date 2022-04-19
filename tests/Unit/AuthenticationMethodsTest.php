<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\User\AuthenticationController;
use App\Models\User;

class AuthenticationMethodsTest extends TestCase
{
    /**
     * test sms code generation .
     *
     * @return void
     */
    public function test_sms_code_generation()
    {
        $user = User::first();
        $auth = new AuthenticationController();
        $code = $auth->smsCode($user);
        $this->assertSame(300,$code);
    }

    public function test_sms_not_expired_code()
    {
        $user = User::find(1);
        $auth = new AuthenticationController();
        $code = $auth->smsCode($user);
        $this->assertSame(546660,$code);   
    }

    public function test_sms_expired_code()
    {
        $user = User::find(1);
        $auth = new AuthenticationController();
        $code = $auth->smsCode($user);
        $this->assertSame(546660,$code);   
    }

    public function test_sms_used_code()
    {
        $user = User::find(1);
        $auth = new AuthenticationController();
        $code = $auth->smsCode($user);
        $this->assertSame(546660,$code);   
    }

    public function test_sms_sending()
    {
        $user = User::find(1);
        $auth = new AuthenticationController();
        $response = $auth->sendSms($user);
        $this->assertSame(true,$response);
    }


}
