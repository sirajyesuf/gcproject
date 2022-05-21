<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\User;

class BookingFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Booking::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'service_id' => \App\Models\Service::factory(),
            'service_provider_id' => \App\Models\ServiceProvider::factory(),
            'user_id' => User::inRandomOrder()->first(),
            'status' => 1,
            'service_date' => $this->faker->date(),
        ];
    }
}
