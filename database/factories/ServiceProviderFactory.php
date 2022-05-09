<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ServiceProvider;

class ServiceProviderFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = ServiceProvider::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'business_name' => $this->faker->word,
            'phone_number' => $this->faker->phoneNumber,
            'owner_name' => $this->faker->word,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'logo' => $this->faker->word,
            'type'=>$this->faker->numberBetween(1,2),
        ];
    }
}
