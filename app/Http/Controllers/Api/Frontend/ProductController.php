<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ClothFor;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Measurement;
use App\Models\Product;
use App\Models\Review;
use App\Models\Search;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('keyword');

        //get search results
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->orderBy('id', 'desc')
            ->get();

        // save search
        if (auth('api')->check()) {
            Search::updateOrCreate(
                ['user_id' => auth('api')->user()->id],
                ['keyword' => $keyword]
            );
        }

        $data = [
            'count'     => $products->count(),
            'products'  => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function filter(Request $request)
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc');

        if ($request->has('category_id') && $request->category_id !== 'all') {
            $products = $products->where('category_id', $request->category_id);
        }

        if ($request->has('size_id') && $request->size_id !== 'all') {
            $products = $products->where('size_id', $request->size_id);
        }

        if ($request->has('condition_id') && $request->condition_id !== 'all') {
            $products = $products->where('condition_id', $request->condition_id);
        }

        if ($request->has('cloth_for_id') && $request->cloth_for_id !== 'all') {
            $products = $products->where('cloth_for_id', $request->cloth_for_id);
        }

        if ($request->has('price') && $request->price !== 'all') {
            $products = $products->where('price_per_day', $request->price);
        }

        if ($request->has('color_id') && $request->color_id !== 'all') {
            $products = $products->where('color_id', $request->color_id);
        }

        if ($request->has('measurement_id') && $request->measurement_id !== 'all') {
            $products = $products->where('measurement_id', $request->measurement_id);
        }

        $products = $products->get();

        $data = [
            'count'     => $products->count(),
            'products'  => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function recommended()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function recommendedAll()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function trending()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function trendingAll()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function trendingRental()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function trendingRentalAll()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function latest()
    {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
            ->with(['Category:id,name,image', 'clothFor:id,name'])
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        $data = [
            'products' => $products
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function show(Product $product, $id)
    {
        $product = Product::with([
            'Category:id,name,image',
            'Size:id,name',
            'ClothFor:id,name',
            'Condition:id,name',
            'Images:id,product_id,image',
            'Reviews:id,user_id,product_id,rating,comment,created_at',
            'Unavailables:id,product_id,booking_id,user_id,booking_date',
            'User:id,name'
        ])
            ->where('id', $id)
            ->first();

        $data = [
            'product' => $product
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function reviewIndex(Product $product, $product_id)
    {
        $reviews = Review::with(['User:id,name'])->where('product_id', $product_id)->get();
        $product = Product::with(['User:id,name'])->where('id', $product_id)->first();

        $data = [
            'product' => $product,
            'reviews' => $reviews
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function sizeIndex()
    {
        $sizes = Size::where('status', 'active')->get();

        $data = [
            'sizes' => $sizes
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function conditionIndex()
    {
        $conditions = Condition::where('status', 'active')->get();

        $data = [
            'conditions' => $conditions
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function clothforIndex()
    {
        $clothfor = ClothFor::where('status', 'active')->get();

        $data = [
            'clothfor' => $clothfor
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function ColorIndex()
    {
        $colors = Color::where('status', 'active')->get();

        $data = [
            'colors' => $colors
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function MeasurementIndex()
    {
        $measurements = Measurement::where('status', 'active')->get();

        $data = [
            'measurements' => $measurements
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }
}
