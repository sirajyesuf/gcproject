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
            'business_name' => 'Addis Ababa University',
            'phone_number' => $this->faker->phoneNumber,
            'owner_name' => $this->faker->word,
            'latitude' =>    9.040017609464645,
            'longitude' =>   38.75933142918076,
            'logo' => $this->faker->word,
            'type'=>$this->faker->numberBetween(1,2),
        ];
    }
}
