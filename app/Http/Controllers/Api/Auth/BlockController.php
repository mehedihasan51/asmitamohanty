<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Follower;
use App\Models\User;

class BlockController extends Controller
{
    public function index() {
        $user = auth('api')->user();
        $block = Block::where('user_id', $user->id)->pluck('blocked_id')->toArray();
        $block = User::select('id', 'name', 'image', 'coin', 'referral_code', 'last_activity_at', 'stripe_account_id')->whereIn('id', $block)->where('id', '!=', $user->id)->get();
        return response()->json(['status' => 'success', 'message' => 'Success', 'code' => 200, 'data' => $block], 200);
    }

    public function toggle($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found', 'code' => 404, 'data' => []], 404);
        }

        if ($user_id == auth('api')->id()) {
            return response()->json(['status' => 'error', 'message' => 'You cannot block yourself', 'code' => 400, 'data' => []], 400);
        }

        $block = Block::where([
            'user_id' => auth('api')->id(),
            'blocked_id' => $user->id,
        ]);

        if ($block->exists()) {
            $block->delete();
            return response()->json(['status' => 'success', 'message' => 'You have successfully unblocked this user', 'code' => 200, 'data' => []], 200);
        }

        Block::create([
            'user_id' => auth('api')->id(),
            'blocked_id' => $user->id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'You have successfully blocked this user', 'code' => 201, 'data' => []], 201);
    }
}
