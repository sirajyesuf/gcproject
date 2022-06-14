<?php

namespace Database\Seeders;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;


class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_date    =   Carbon::now()->subMonths(2);
        $second_date   =   $first_date->copy()->addWeek();
        $third_date    =   $second_date->copy()->addWeek();
        $fourth_date   =   $third_date->copy()->addWeek();
        $fifth_date    =   $fourth_date->copy()->addWeek();
        $sixth_date    =   $fifth_date->copy()->addWeek();
        $seventh_date  =   $sixth_date->copy()->addWeek();
        $eight_date    =   $seventh_date->copy()->addWeek();


        Booking::factory(8)->state(new Sequence(
            ['service_date'=>$first_date],
            ['service_date'=>$second_date],
            ['service_date'=>$third_date],
            ['service_date'=>$fourth_date],
            ['service_date'=>$fifth_date],
            ['service_date'=>$sixth_date],
            ['service_date'=>$seventh_date],
            ['service_date'=>$eight_date]
        ))->create();
    }
}
