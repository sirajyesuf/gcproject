<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SmsCode;

class SmsCodeFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = SmsCode::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'code' => $this->faker->randomNumber(),
            'status' => $this->faker->boolean,
            'service_provider_id' => $this->faker->randomNumber(),
        ];
    }
}
