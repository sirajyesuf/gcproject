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

        $dates =  [
            $first_date,
            $second_date,
            $third_date,
            $fourth_date,
            $fifth_date,
            $sixth_date,
            $seventh_date,
            $eight_date
        ];
      foreach($dates as $date){
        Booking::factory()->count(1)->create(['service_date'=>$date]);
      }
    }
}
