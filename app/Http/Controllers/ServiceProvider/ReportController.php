<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private $serviceProvider;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->serviceProvider = Auth::guard('service_provider')->user();
    } 

    public function earnings()
    {
       $earnings = Booking::where('service_provider_id',$this->serviceProvider->id)
                            ->where('status',2)
                            ->select(DB::raw('sum(amount) as total_earn,service_date'))
                            ->groupBy('service_date')
                            ->paginate(10);
        $resource = (new BookingResourceCollection($earnings));
        return response()->json($resource->response()->getData(),Response::HTTP_OK);                    
    }

    public function bookings()
    {

    }

}
