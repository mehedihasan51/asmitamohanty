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

class ProductController extends Controller
{
    public function index() {
        $products = Product::select('id', 'title', 'thumb', 'price_per_day', 'cloth_for_id')
        ->with(['category:id,name,image', 'color:id,name', 'measurement:id,name', 'images:id,product_id,image', 'size:id,name', 'condition:id,name', 'clothFor:id,name'])
        ->where('user_id', auth('api')->user()->id)
        ->orderBy('id', 'desc')
        ->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $products);
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'thumb'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'description'       => 'nullable|string',
            'price_per_day'     => 'required|numeric|min:1',
            'quantity'          => 'required|numeric|min:1',
            'size_id'           => 'nullable|exists:sizes,id',
            'color_id'          => 'nullable|string',
            'measurement_id'    => 'nullable|exists:measurements,id',
            'highlights'        => 'nullable|string',
            'condition_id'      => 'nullable|exists:conditions,id',
            'cloth_for_id'      => 'nullable|exists:cloth_fors,id',
            'category_id'       => 'required|exists:categories,id',
            'images'            => 'nullable|array|max:3|min:1',
            'images.*'          => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            // Retrieve validated data from the validator
            $data = $validator->validated();

            $product = new Product();
            $product->user_id = auth('api')->user()->id;

            // Handle the thumbnail upload
            if ($request->hasFile('thumb')) {
                $data['thumb'] = Helper::fileUpload($request->file('thumb'), 'product', time() . '_' . getFileName($request->file('thumb')));
            }

            // Generate slug and ensure it's unique
            $slug = Helper::makeSlug(Product::class, $data['title']);
            while (Product::where('slug', $slug)->exists()) {
                $slug = Helper::makeSlug(Product::class, $data['title']) . '-' . Str::random(3);
            }
            $product->slug = $slug;

            // Fill product details
            $product->title             = $data['title'];
            $product->thumb             = $data['thumb'] ?? null;
            $product->description       = $data['description'] ?? null;
            $product->price_per_day     = $data['price_per_day'];
            $product->quantity          = $data['quantity'];
            $product->size_id           = $data['size_id'];
            $product->color_id          = $data['color_id'];
            $product->measurement_id    = $data['measurement_id'] ?? null;
            $product->highlights        = $data['highlights'] ?? null;
            $product->condition_id      = $data['condition_id'];
            $product->cloth_for_id      = $data['cloth_for_id'];
            $product->category_id       = $data['category_id'];
            $product->save();

            //image upload code start
            if (!empty($request['images']) && count($request['images']) > 0 && count($request['images']) <= 3) {
                foreach ($request['images'] as $image) {
                    $imageName = 'images_' . Str::random(10);
                    $image = Helper::fileUpload($image, 'products', $imageName);
                    Image::create(['product_id' => $product->id, 'image' => $image]);
                }
            }else{
                return Helper::jsonResponse(false, 'Maximum 3 images allowed', 422, $validator->errors());
            }
            //image upload code end

            // Retrieve the product along with associated category and images
            $product = Product::with(['category:id,name,image', 'color:id,name', 'measurement:id,name', 'images:id,product_id,image', 'size:id,name', 'condition:id,name', 'clothFor:id,name'])->where('id', $product->id)->first();

            return Helper::jsonResponse(true, 'Product created successfully', 200, $product);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating the new product', 500, ['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $products = Product::with(['category:id,name,image', 'color:id,name', 'measurement:id,name', 'images:id,product_id,image', 'size:id,name', 'condition:id,name', 'clothFor:id,name'])->where('id', $id)->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'thumb'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'description'       => 'nullable|string',
            'price_per_day'     => 'required|numeric|min:1',
            'quantity'          => 'required|numeric|min:1',
            'size_id'           => 'nullable|exists:sizes,id',
            'color_id'          => 'nullable|string',
            'measurement_id'    => 'nullable|exists:measurements,id',
            'highlights'        => 'nullable|string',
            'condition_id'      => 'nullable|exists:conditions,id',
            'cloth_for_id'      => 'nullable|exists:cloth_fors,id',
            'category_id'       => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            // Retrieve validated data from the validator
            $data = $validator->validated();

            $product = Product::where('user_id', auth('api')->user()->id)->find($request->id);

            // Check if the authenticated user is the owner of the product
            if (!$product) {
                return Helper::jsonResponse(false, 'You are not authorized to update this product', 401);
            }

            // Handle the thumbnail upload
            if ($request->hasFile('thumb')) {
                $validate['thumb'] = Helper::fileUpload($request->file('thumb'), 'product', time() . '_' . getFileName($request->file('thumb')));
            }

            // Fill product details
            $product->title             = $data['title'];
            $product->thumb             = $validate['thumb'] ?? $product->thumb ?? null;
            $product->description       = $data['description'] ?? null;
            $product->price_per_day     = $data['price_per_day'];
            $product->quantity          = $data['quantity'];
            $product->size_id           = $data['size_id'];
            $product->color_id          = $data['color_id'];
            $product->measurement_id    = $data['measurement_id'] ?? null;
            $product->highlights        = $data['highlights'] ?? null;
            $product->condition_id      = $data['condition_id'];
            $product->cloth_for_id      = $data['cloth_for_id'];
            $product->category_id       = $data['category_id'];
            $product->save();

            $product = Product::with(['category:id,name,image', 'color:id,name', 'measurement:id,name', 'images:id,product_id,image', 'size:id,name', 'condition:id,name', 'clothFor:id,name'])->where('id', $product->id)->first();

            return Helper::jsonResponse(true, 'Product created successfully', 200, $product);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating the new product', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::where('user_id', auth('api')->user()->id)->find($id);

        if (!$product) {
            return Helper::jsonResponse(false, 'Product not found', 404);
        }

        if ($product->user_id !== auth('api')->user()->id) {
            return Helper::jsonResponse(false, 'You are not authorized to delete this Product', 403);
        }

        if ($product->image && file_exists(public_path($product->image))) {
            Helper::fileDelete(public_path($product->image));
        }
        if($product->images){
            foreach ($product->images as $image) {
                if ($image->image && file_exists(public_path($image->image))) {
                    Helper::fileDelete(public_path($image->image));
                }
            }
        }

        $product->delete();

        return Helper::jsonResponse(true, 'Post deleted successfully', 200);
    }

}
