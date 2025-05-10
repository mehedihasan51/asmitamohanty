<?php

namespace App\Http\Controllers\Api\Renter;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Unavailable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeWebHookBookingController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id'    => 'required|exists:products,id',
            'package_id'    => 'nullable|exists:packages,id',
            'price'         => 'required|numeric',
            'booking_date'  => 'required|array'
        ]);



        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }



        do {
            $uid = "asm_" . Str::random(10);
        } while (Booking::where('uid', $uid)->exists());

        $booking = Booking::create([
            'product_id'    => $request->product_id,
            'user_id'       => auth('api')->user()->id,
            'uid'           => $uid,
            'total_price'   => $request->price
        ]);



        foreach ($request->booking_date as $date) {
            Unavailable::create([
                'product_id'    => $request->product_id,
                'booking_id'    => $booking->id,
                'user_id'       => auth('api')->user()->id,
                'booking_date'  => $date
            ]);
        }


        return  $this->intent($booking->id);
    }

    public function intent($booking_id): JsonResponse
    {
        $booking = Booking::find($booking_id);
        $product = Product::find($booking->product_id);
        $stripe_account_id = $product->user->stripe_account_id;

        $total_price = $booking->total_price;
        $admin_price = $total_price * (10 / 100);
        $owner_price = $total_price - $admin_price;
        if (!$booking) {
            return Helper::jsonResponse(false, 'Booking not found', 404, []);
        }


        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = PaymentIntent::create([
                'amount'   => $owner_price * 100,
                'currency' => 'usd',
                'metadata' => [
                    'booking_id' => $booking_id
                ],
                'transfer_data' => [
                    'destination' => $stripe_account_id
                ],
                'application_fee_amount' => $admin_price * 100
            ]);
            $data = [
                'client_secret' => $paymentIntent->client_secret,
                'booking_date'   => $booking->unavailables->pluck('booking_date')->toArray(),
            ];
            return Helper::jsonResponse(true, 'Payment intent created successfully', 200, $data);
        } catch (ApiErrorException $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500, []);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500, []);
        }
    }
}
