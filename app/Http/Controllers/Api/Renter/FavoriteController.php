<?php

namespace App\Http\Controllers\Api\Renter;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $products = Favorite::where('user_id', auth('api')->user()->id)
            ->with(['Product' => function ($query) {
                $query->select('id', 'title', 'thumb', 'price_per_day', 'cloth_for')
                    ->with(['Category:id,name,image']);
            }])
            ->orderBy('id', 'desc')
            ->get()
            ->pluck('Product');

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data); 
    }

    public function toggle($product_id) {
        try{
            $favorite_exist = Favorite::where('product_id', $product_id)->where('user_id', auth('api')->user()->id)->first();
            if ($favorite_exist) {
                $favorite_exist->delete();
                return Helper::jsonResponse(true, 'Post removed from favorites successfully', 200);
            } else {
                Favorite::create([
                    'product_id' => $product_id,
                    'user_id' => auth('api')->user()->id
                ]);
                return Helper::jsonResponse(true, 'Post added to favorites successfully', 200);
            }
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

}