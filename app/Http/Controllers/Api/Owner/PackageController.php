<?php

namespace App\Http\Controllers\Api\Owner;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Image;
use App\Models\Package;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index($product_id)
    {
        $packages = Package::where('product_id', $product_id)->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $packages);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'        => 'required|exists:products,id',
            'date'              => 'numeric|min:3|max:30',
            'price_per_day'     => 'numeric|min:1|max:100000',
            'type'              => 'required|in:basic,premium,standard',
            'recommended'       => 'required|in:yes,no'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation Error', 422, $validator->errors());
        }

        $package_count = Package::where('product_id', $request->product_id)->count();
        if ($package_count >= 3) {
            return Helper::jsonResponse(false, 'Maximum 3 packages allowed', 422);
        }

        try {
            $package = Package::create([
                'product_id'        => $request->product_id,
                'name'              => $request->name,
                'day'               => $request->date,
                'price_per_day'     => $request->price_per_day,
                'type'              => $request->type,
                'recommended'       => $request->recommended,
            ]);

            return Helper::jsonResponse(true, 'Package created successfully', 200, $package);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'Something went wrong', 500, $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'        => 'required|exists:products,id',
            'date'              => 'numeric|min:3|max:30',
            'price_per_day'     => 'numeric|min:1|max:100000',
            'type'              => 'required|in:basic,premium,standard',
            'recommended'       => 'required|in:yes,no'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation Error', 422, $validator->errors());
        }

        try {
            $package = Package::find($id);
            $package->update([
                'product_id'        => $request->product_id,
                'name'              => $request->name,
                'day'               => $request->date,
                'price_per_day'     => $request->price_per_day,
                'type'              => $request->type,
                'recommended'       => $request->recommended,
            ]);

            return Helper::jsonResponse(true, 'Package updated successfully', 200, $package);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'Something went wrong', 500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        if(!$package) {
            return Helper::jsonResponse(false, 'Package not found', 404);
        }
        $package->delete();
        return Helper::jsonResponse(true, 'Package deleted successfully', 200, $package);
    }
}
