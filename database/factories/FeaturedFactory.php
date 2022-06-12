<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Featured;
use App\Models\ServiceProvider;

class FeaturedFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Featured::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'image_path'           =>   $this->faker->word,
            'title'                =>   $this->faker->title,
            'description'          =>   $this->faker->text,
            'status'               =>   $this->faker->boolean,
            'service_provider_id'  =>   ServiceProvider::inRandomOrder()->first(),
        ];
    }
}
