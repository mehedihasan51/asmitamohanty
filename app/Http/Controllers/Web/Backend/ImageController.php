<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Exception;

class ImageController extends Controller
{
    public function index($product_id)
    {
        $images = Image::where('product_id', $product_id)->get();
        $data = [
            'images' => $images
        ];
        return response()->json([
            'status' => 't-success',
            'message' => 'Your action was successful!',
            'data' => $data
        ]);
        
    }
    public function destroy(string $id)
    {
        try {
            $data = Image::findOrFail($id);
            if ($data->image && file_exists(public_path($data->image))) {
                Helper::fileDelete(public_path($data->image));
            }
            $data->delete();
            return response()->json([
                'product_id' => $data->product_id,
                'status' => 't-success',
                'message' => 'Your action was successful!'
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 't-error',
                'message' => 'Your action was successful!'
            ]);
        }
    }

}
