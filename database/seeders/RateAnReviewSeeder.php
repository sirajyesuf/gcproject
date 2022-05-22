<?php

namespace Database\Seeders;

use App\Models\User\RateAndReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RateAnReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RateAndReview::factory(20)->create();
    }
}
