<?php
namespace App\Http\Controllers\Api\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::select('id', 'name', 'slug', 'image')->get();
            $data = [
                'categories' => $categories
            ];
            return Helper::jsonResponse(true, 'Categories fetched successfully', 200, $data);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'Something went wrong', 500);
        }
    }
}