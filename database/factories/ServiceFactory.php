<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

class ServiceFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Service::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(),
            'type' => $this->faker->randomElement([1,2]),
            'image' => $this->faker->word,
            'service_provider_id' => \App\Models\ServiceProvider::factory(),
        ];
    }
}
