<?php

namespace App\Http\Controllers\ServiceProvider;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RateAndReviewResource;

class RateAndReviewController extends Controller
{
    public function reviews()
    {
      $serviceProvider = Auth::guard('service_provider')->user();
      $reviews = $serviceProvider->reviews()->paginate(10);
      $resourses =  (new RateAndReviewResource($reviews));
      return response()->json($resourses->response()->getData(),Response::HTTP_OK);
    }
}
