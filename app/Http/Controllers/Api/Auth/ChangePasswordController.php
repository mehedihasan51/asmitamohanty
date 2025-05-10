<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'          => 'required|string|min:6',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return Helper::jsonErrorResponse($validator->errors()->first(), 400);
        }

        try {
            $user = Auth::guard('api')->user();

            if (!Hash::check($request->old_password, $user->password)) {
                return Helper::jsonErrorResponse('Old password does not match', 400);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            Auth::guard('api')->logout();

            return Helper::jsonResponse(true, 'Password changed successfully.', 200);
        } catch (Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
}
