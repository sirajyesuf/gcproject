<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\AddAndReviewRequest;
use App\Http\Resources\RateAndReviewResource;
use App\Models\User\RateAndReview;
use App\Services\GeneralServices;

class RateAnReviewController extends Controller
{
    public function add(AddAndReviewRequest $addAndReviewRequest)
    {
        $inputs = $addAndReviewRequest->all();
        $user = Auth::guard('user')->user();
        $review = $user->rateAndReviews()->where('service_provider_id',$inputs['service_provider_id'])->exists();
        $service_check = $user->bookings()->where('service_provider_id',$inputs['service_provider_id'])->where('status',2)->exists();
        if($review){
          return response()->json(['status'=>'failed','message'=>'you cant add review more than once for one service provider'],Response::HTTP_ACCEPTED);
        }
        if(!$service_check){
            return response()->json(['status'=>'failed','message'=>'you didnt take service on this customer'],Response::HTTP_ACCEPTED);
        }
        $data = $user->rateAndReviews()->create($inputs);
        return response()->json($data,Response::HTTP_CREATED);
    }

    public function edit(AddAndReviewRequest $addAndReviewRequest,$id)
    {
        $inputs = $addAndReviewRequest->all(); 
        $user = Auth::guard('user')->user();
        $review = RateAndReview::findOrFail($id);
        $review->update($inputs);
        $review->refresh();
        return response()->json($review,Response::HTTP_OK);
    }

    public function serviceProviderReviews($service_provider_id)
    {
      $reviews = RateAndReview::with('user')->where('service_provider_id',$service_provider_id)->paginate(10);
      $resourses =  (new RateAndReviewResource($reviews));
      return response()->json($resourses->response()->getData(),Response::HTTP_OK);
    }
}
