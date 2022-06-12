<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Withdraw;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdraw>
 */
class WithdrawFactory extends Factory
{

    protected $model = Withdraw::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'amount' => $this->faker->randomDigit(),
            'service_provider_id' => \App\Models\ServiceProvider::all()->random()->id,
            'status' => $this->faker->randomElement([1, 2, 3])
        ];
    }
}
