<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Featured;
use Illuminate\Http\Request;

class FeaturedController extends Controller
{
    public function featureds()
    {
        $featured = Featured::where('status',true)->get();
        return response()->json($featured,200);
    }
}
