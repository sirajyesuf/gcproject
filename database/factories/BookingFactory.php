<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\Service;
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
        $service = Service::inRandomOrder()->first();
        return [
            'id' => $this->faker->uuid,
            'service_id' => $service->id,
            'service_provider_id' => $service->service_provider_id,
            'user_id' => 2,
            'status' => 2,
        ];
    }
}
