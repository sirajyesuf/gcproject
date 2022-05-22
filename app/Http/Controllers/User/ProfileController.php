<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function user($user_id)
    {
        $user = User::findOrFail($user_id);
        return response()->json($user,200); 
    }
}
