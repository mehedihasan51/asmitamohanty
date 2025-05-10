<?php

namespace App\Http\Controllers\Api\Renter;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        try {
            $product = Product::find($product_id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found', 'data' => [], 'code' => 200]);
            }

            $review = $product->reviews()->where('user_id', auth('api')->user()->id)->first();
            if ($review) {
                return response()->json(['success' => false, 'message' => 'You already submitted a review for this product', 'data' => [], 'code' => 422]);
            }

            $review = $product->reviews()->create([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'user_id' => auth('api')->user()->id,
            ]);

            $data = [
                'review' => $review
            ];

            return response()->json([
                'success' => true,
                'message' => 'Review created successfully',
                'data' => $data,
                'code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'code' => 500
            ]);
        }
    }
        

}