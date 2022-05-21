<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\GeneralServices;
use Tests\TestCase;

class GeneralServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_deposit_one()
    {
        $user = User::find(11);
        $service = new GeneralServices;
        $this->assertEquals(13,$service->userDeposit($user));
    }

    

    public function test_user_expense()
    {
        $user = User::find(10);
        $service = new GeneralServices;
        $this->assertEquals(127362431,$service->userExpense($user));
    }

    public function test_user_expense_one()
    {
        $user = User::find(11);
        $service = new GeneralServices;
        $this->assertEquals(0,$service->userExpense($user));
    }

    public function test_user_expense_two()
    {
        $user = User::find(4);
        $service = new GeneralServices;
        $this->assertEquals((46.14+32.68833),$service->userExpense($user));
    }

    public function test_user_expense_three()
    {
        $user = User::find(4);
        $service = new GeneralServices;
        $this->assertEquals((46.14+32.68833),$service->userExpense($user));
    }


    public function test_user_balance_one()
    {
        $user = User::find(1);
        $service = new GeneralServices;
        $this->assertEquals((100-160771250.3),$service->userBalance($user));
    }

    public function test_user_eligibility()
    {
        $user = User::find(1);
        $service = new GeneralServices;
        $this->assertEquals(false,$service->checkUserBookingEligibilty($user,1));
    }

    public function test_user_eligibility_one()
    {
        $user = User::find(12);
        $service = new GeneralServices;
        $this->assertEquals(true,$service->checkUserBookingEligibilty($user,1));
    }


}
