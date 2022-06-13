<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class ContextAwareAndRecommendaionController extends Controller
{
    public function seeRecommendations()
    {
        $users = User::all();
        foreach($users as $user){
            $bookings = Booking::where('user_id',$user->id)->get();
            foreach($bookings as $booking){
                
            }
        }
    }
}
