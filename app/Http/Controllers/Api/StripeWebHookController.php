<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Account;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\AccountLink;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use UnexpectedValueException;
use Illuminate\Support\Facades\Log;
use Stripe\Payout;

class StripeWebHookController extends Controller
{
    

    public function webhook(Request $request): JsonResponse
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload        = $request->getContent();
        $sigHeader      = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (UnexpectedValueException $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 400, []);
        } catch (SignatureVerificationException $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 400, []);
        }

        //? Handle the event based on its type
        try {
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->success($event->data->object);
                    return Helper::jsonResponse(true, 'Payment successful', 200, []);

                case 'payment_intent.payment_failed':
                    $this->failure($event->data->object);
                    return Helper::jsonResponse(true, 'Payment failed', 200, []);

                default:
                    return Helper::jsonResponse(true, 'Unhandled event type', 200, []);
            }
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500, []);
        }
    }

    protected function success($paymentIntent): void
    {
        $trx_id     = $paymentIntent->id;
        $fee        = $paymentIntent->application_fee_amount;
        $amount     = $paymentIntent->amount;
        $booking_id = $paymentIntent->metadata->booking_id;
        $booking    = Booking::find($booking_id);
        $product    = Product::find($booking->product_id);
        $owner      = User::find($product->user_id);
        $customer   = User::find($booking->user_id);
        $admin      = User::role('admin')->first();

        if ($booking) {
            $booking->update(['payment_status' => 'paid']);
        }

        Transaction::create([
            "user_id" => $owner->id,
            "amount" => $amount / 100,
            "trx_id" => $trx_id,
            "type" => "increment",
            "title" => "Payment from " . $owner->name,
            "gateway" => "Stripe",
            "status" => "success",
            "metadata" => json_encode([
                "booking_id" => $booking_id,
                "owner_id" => $owner->id,
                "customer_id" => $customer->id,
                "admin_id" => $admin->id,
                "product_id" => $product->id,
            ])
        ]);

        Transaction::create([
            "user_id" => $admin->id,
            "amount" => $fee / 100,
            "trx_id" => $trx_id,
            "type" => "increment",
            "title" => "Payment from " . $owner->name,
            "gateway" => "Stripe",
            "status" => "success",
            "metadata" => json_encode([
                "booking_id" => $booking_id,
                "owner_id" => $owner->id,
                "customer_id" => $customer->id,
                "admin_id" => $admin->id,
                "product_id" => $product->id,
            ])
        ]);
    }

    protected function failure($paymentIntent): void
    {
        $booking_id = $paymentIntent->metadata->booking_id;
        $booking = Booking::find($booking_id);
        if ($booking) {
            $booking->update(['payment_status' => 'failed']);
        }
    }

    public function withdrawRequest(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'stripe_token' => 'required|string'
        ]);

        $user = auth('api')->user();

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $account = Account::retrieve($user->stripe_account_id);

            $account->external_accounts->create([
                'external_account' => $request->stripe_token
            ]);

            Payout::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
            ], [
                'stripe_account' => $user->stripe_account_id
            ]);

            return Helper::jsonResponse(true, 'Withdrawal successful', 200, []);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return Helper::jsonResponse(false, 'Something went wrong', 500, []);
        }
    }

}
