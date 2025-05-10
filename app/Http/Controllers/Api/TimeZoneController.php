<?php

namespace App\Http\Controllers\Api;

use App\Events\TestNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TestNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TimeZoneController extends Controller
{
    public function set(Request $request)
    {
        Session::put('timezone', $request->timezone);

        $data = [
            'timezone' => Session::get('timezone')
        ];
        return response()->json([
            'success' => true,
            'message' => 'Timezone set successfully',
            'data' => $data,
            'code' => 200
        ]);
    }

    public function get() {
        $data = [
            'timezone' => Session::get('timezone')
        ];

        return response()->json([
            'success' => true,
            'message' => 'Timezone get successfully',
            'data' => $data,
            'code' => 200
        ]);
    }

}
