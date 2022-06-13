<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpParser\Node\Expr\FuncCall;

class RateAndReviewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_with_out_authentication()
    {
        // $user = User::find(1);
        $token = 'kfjklsdjfkl';
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/add_review');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_with_out_data()
    {
        $user = User::find(1);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/add_review');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_with_invalid_rate()
    {
      $data = [
          'rate'=>10,
          'review'=>'good nice',
          'service_provider_id'=>132
      ];

        $user = User::find(17);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/add_review',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_with_out_taking_service()
    {
        $data = [
            'rate'=>5,
            'review'=>'good nice',
            'service_provider_id'=>132
        ];
  
          $user = User::find(1);
          $token = $user->createToken('test device')->plainTextToken;
          $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/add_review',$data);
          $response->dump();
          $response->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_with_valid_data()
    {
        $data = [
            'rate'=>5,
            'review'=>'good nice',
            'service_provider_id'=>132
        ];
  
          $user = User::find(17);
          $token = $user->createToken('test device')->plainTextToken;
          $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/add_review',$data);
          $response->dump();
          $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_with_duplicate_rate()
    {
        $data = [
            'rate'=>5,
            'review'=>'good nice',
            'service_provider_id'=>132
        ];
  
          $user = User::find(17);
          $token = $user->createToken('test device')->plainTextToken;
          $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/add_review',$data);
          $response->dump();
          $response->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_edit_with_out_authentication()
    {
        // $user = User::find(1);
        $token = 'kfjklsdjfkl';
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_review/1');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_edit_with_out_data()
    {
        $user = User::find(17);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_review/1');
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_edit_with_invalid_rate()
    {
      $data = [
          'rate'=>10,
          'review'=>'good nice',
          'service_provider_id'=>132
      ];

        $user = User::find(17);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_review/1',$data);
        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_edit_with_valid_data()
    {
        $data = [
            'rate'=>5,
            'review'=>'updated review',
            'service_provider_id'=>132
        ];
  
          $user = User::find(17);
          $token = $user->createToken('test device')->plainTextToken;
          $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->postJson('/user/edit_review/1',$data);
          $response->dump();
          $response->assertStatus(Response::HTTP_OK);
    }

    public function test_fetch_service_provider_reviews()
    {  
        $user = User::find(12);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/user/service_provider_reviews/132');
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);

    }

    public function test_check_review_eligibility_one()
    {
        $user = User::find(17);
        $token = $user->createToken('test device')->plainTextToken;
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('user/check_review_eligibility/1');
        $response->dump();
        $response->assertStatus(Response::HTTP_OK);
    }
}
