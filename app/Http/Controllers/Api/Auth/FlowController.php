<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;

class FlowController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        $follow = Follower::where('follower_id', $user->id)->pluck('user_id')->toArray();
        $follow = User::select('id', 'name', 'image', 'coin', 'referral_code', 'last_activity_at', 'stripe_account_id')->whereIn('id', $follow)->where('id', '!=', $user->id)->get();
        return response()->json(['status' => 'success', 'message' => 'Success', 'code' => 200, 'data' => $follow], 200);
    }
    
    public function toggle($user_id)
    {
        $user = User::find($user_id);
        if(!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found', 'code' => 404, 'data' => []], 404);
        }

        if ($user_id == auth('api')->id()) {
            return response()->json(['status' => 'error', 'message' => 'You can\'t follow yourself', 'code' => 400, 'data' => []], 400);
        }

        $follower = Follower::where([
            'user_id' => $user->id,
            'follower_id' => auth('api')->id(),
        ]);

        if ($follower->exists()) {
            $follower->delete();
            return response()->json(['status' => 'success', 'message' => 'You have successfully unfollowed this user', 'code' => 200, 'data' => []], 200);
        }

        $follower = Follower::create([
            'user_id' => $user->id,
            'follower_id' => auth('api')->id(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'You have successfully followed this user', 'code' => 201, 'data' => []], 201);
    }
}
