<?php

namespace App\Http\Controllers\ServiceProvider;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RateAndReviewResource;
use App\Models\User\RateAndReview;

class RateAndReviewController extends Controller
{
    public function reviews()
    {
      $serviceProvider = Auth::guard('service_provider')->user();
      $reviews = RateAndReview::with('user:id,name,profile_picture')->where('service_provider_id',$serviceProvider->id)->get();
      $resourses =  (new RateAndReviewResource($reviews));
      return response()->json($resourses->response()->getData(),Response::HTTP_OK);
    }
}
