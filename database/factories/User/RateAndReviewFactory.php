<?php

namespace Database\Factories\user;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User\RateAndReview;

class RateAndReviewFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = RateAndReview::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'rate' => $this->faker->numberBetween(1,5),
            'review' => $this->faker->word,
            'user_id' => User::inRandomOrder()->first(),
            'service_provider_id' => 132,
        ];
    }
}
