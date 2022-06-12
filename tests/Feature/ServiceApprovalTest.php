<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceApprovalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_service_approval_one()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $booking_id = '00055397-a577-3744-a77c-d6a88ad2eaa8';
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
        ->get('/user/get_approval_token/'.$booking_id);
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['approval_token']);
        $data = $response->decodeResponseJson();

        $approval_token = $data['approval_token'];
        $serviceProvider = ServiceProvider::findOrFail(1);
        $token = $serviceProvider->createToken('test device')->plainTextToken;

        $data = [
            'approval_token' => $approval_token,
        ];
        $response1 = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])
        ->postJson('/service_provider/approve_service/'.$booking_id,$data);
          
        $response1->dump();
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('bookings',[
            'id'=>$booking_id,
            'status'=>2
        ]);
    }
}
