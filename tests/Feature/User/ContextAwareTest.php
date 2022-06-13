<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContextAwareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_context_aware_test()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
