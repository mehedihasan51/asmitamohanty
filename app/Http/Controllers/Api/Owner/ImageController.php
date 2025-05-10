<?php

namespace App\Http\Controllers\Api\Owner;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Image;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index($product_id) {
        $images = Image::where('product_id', $product_id)->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $images);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'        => 'required|exists:products,id',
            'images'            => 'required|array|max:3',
            'images.*'          => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            $data = $validator->validated();
            $image_count = Image::where('product_id', $data['product_id'])->count();
            $total_image_count = $image_count + count($request['images']);

            if ($total_image_count > 3 ) {
                return Helper::jsonResponse(false, 'Maximum 3 images allowed', 422, $validator->errors());
            }

            //image upload code start
            if (!empty($request['images']) && count($request['images']) > 0 && count($request['images']) <= 3) {
                foreach ($request['images'] as $image) {
                    $imageName = 'images_' . Str::random(10);
                    $image = Helper::fileUpload($image, 'products', $imageName);
                    Image::create(['product_id' => $data['product_id'], 'image' => $image]);
                }
            }else{
                return Helper::jsonResponse(false, 'Maximum 3 images allowed', 422, $validator->errors());
            }
            //image upload code end

            // Retrieve the product along with associated category and images
            $image = Image::where('product_id', $data['product_id'])->get();

            return Helper::jsonResponse(true, 'Product Image created successfully', 200, $image);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating the new product', 500, ['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return Helper::jsonResponse(false, 'Image not found', 404);
        }
        $image->delete();
        return Helper::jsonResponse(true, 'Image deleted successfully', 200, $image);
    }

}
