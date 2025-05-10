<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClothFor;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Image;
use App\Models\Measurement;
use App\Models\Size;
use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with(['user'])->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    return Str::limit($data->title, 20);
                })
                ->addColumn('category', function ($data) {
                    return $data->category->name;
                })
                ->addColumn('size', function ($data) {
                    return $data->size->name;
                })
                ->addColumn('color', function ($data) {
                    return $data->color->name;
                })
                ->addColumn('cloth_for', function ($data) {
                    return $data->color->name;
                })
                ->addColumn('condition', function ($data) {
                    return $data->color->name;
                })
                ->addColumn('author', function ($data) {
                    return "<a href='" . route('admin.users.show', $data->user->id) . "'>" . $data->user->name . "</a>";
                })
                ->addColumn('thumb', function ($data) {
                    if ($data->thumb) {
                        $url = asset($data->thumb);
                        return '<img src="' . $url . '" alt="thumb" width="50px" height="50px" style="margin-left:20px;">';
                    } else {
                        return '<img src="' . asset('default/logo.png') . '" alt="image" width="50px" height="50px" style="margin-left:20px;">';
                    }
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                <a href="#" type="button" onclick="goToEdit(' . $data->id . ')" class="btn btn-primary fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-edit"></i>
                                </a>

                                <a href="#" type="button" onclick="goToOpen(' . $data->id . ')" class="btn btn-success fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-eye"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['title', 'category', 'size', 'color', 'cloth_for', 'condition', 'author', 'thumb' ,'status', 'action'])
                ->make();
        }
        return view("backend.layouts.product.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories     = Category::where('status', 'active')->get();
        $sizes          = Size::where('status', 'active')->get();
        $colors         = Color::where('status', 'active')->get();
        $measurements   = Measurement::where('status', 'active')->get();
        $conditions     = Condition::where('status', 'active')->get();
        $cloth_fors     = ClothFor::where('status', 'active')->get();
        return view('backend.layouts.product.create', compact('categories', 'sizes', 'conditions', 'cloth_fors', 'colors', 'measurements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required|string|max:255',
            'thumb'                 => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'description'           => 'nullable|string',
            'price_per_day'         => 'required|numeric|min:1',
            'quantity'              => 'required|numeric|min:1',
            'size_id'               => 'required|exists:sizes,id',
            'color_id'              => 'required|exists:colors,id',
            'measurement_id'        => 'nullable|exists:measurements,id',
            'highlights'            => 'nullable|string',
            'condition_id'          => 'required|exists:conditions,id',
            'cloth_for_id'          => 'required|exists:cloth_fors,id',
            'category_id'           => 'required|exists:categories,id',
            'images'                => 'required|array|max:3|min:1',
            'images.*'              => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            $product = new Product();
            $product->user_id = auth('web')->user()->id;


            if ($request->hasFile('thumb')) {
                $data['thumb'] = Helper::fileUpload($request->file('thumb'), 'product', time() . '_' . getFileName($request->file('thumb')));
            }

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
                session()->put('t-error', 'Please select at least one image');
            }

            session()->put('t-success', 'product created successfully');
        } catch (Exception $e) {
            session()->put('t-error', $e->getMessage());
        }
        return redirect()->route('admin.product.index')->with('t-success', 'product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product, $id)
    {
        $product = Product::with(['user', 'category', 'images', 'size', 'condition', 'clothFor', 'color', 'measurement'])->findOrFail($id);
        return view('backend.layouts.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product, $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        $colors = Color::where('status', 'active')->get();
        $measurements = Measurement::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();
        $conditions = Condition::where('status', 'active')->get();
        $cloth_fors = ClothFor::where('status', 'active')->get();
        return view('backend.layouts.product.edit', compact('product', 'categories', 'sizes', 'conditions', 'cloth_fors', 'colors', 'measurements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'thumb'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'description'       => 'nullable|string',
            'price_per_day'     => 'required|numeric|min:1',
            'quantity'          => 'required|numeric|min:1',
            'size_id'           => 'required|exists:sizes,id',
            'color_id'          => 'required|exists:colors,id',
            'measurement_id'    => 'nullable|exists:measurements,id',
            'highlights'        => 'nullable|string',
            'condition_id'      => 'required|exists:conditions,id',
            'cloth_for_id'      => 'required|exists:cloth_fors,id',
            'category_id'       => 'required|exists:categories,id',
            'images'            => 'nullable|array|max:3',
            'images.*'          => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            $product = Product::findOrFail($id);

            if ($request->hasFile('thumb')) {
                $validate['thumb'] = Helper::fileUpload($request->file('thumb'), 'products', time() . '_' . getFileName($request->file('thumb')));
            }

            // Fill product details
            $product->title             = $data['title'];
            $product->thumb             = $validate['thumb'] ?? $product->thumb ?? null;
            $product->description       = $data['description'] ?? null;
            $product->price_per_day     = $data['price_per_day'];
            $product->quantity          = $data['quantity'];
            $product->size_id           = $data['size_id'];
            $product->color_id          = $data['color_id'];
            $product->measurement_id    = $data['measurement_id'];
            $product->highlights        = $data['highlights'] ?? null;
            $product->condition_id      = $data['condition_id'];
            $product->cloth_for_id      = $data['cloth_for_id'];
            $product->category_id       = $data['category_id'];
            $product->save();

            //image upload code start
            $image_count = Image::where('product_id', $product->id)->count();
            $new_images_count = $request->has('images') ? count($request['images']) : 0;

            if (($image_count + $new_images_count) > 3) {
                session()->put('t-error', 'Please select at most 3 images');
            } else {
                if ($new_images_count > 0) {
                    foreach ($request->file('images') as $image) {
                        $imageName = 'images_' . Str::random(10);
                        $uploadedImagePath = Helper::fileUpload($image, 'products', $imageName);
                        Image::create(['product_id' => $product->id, 'image' => $uploadedImagePath]);
                    }
                }
            }

            session()->put('t-success', 'product updated successfully');

        } catch (Exception $e) {

            session()->put('t-error', $e->getMessage());

        }
        return redirect()->route('admin.product.index')->with('t-success', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Product::findOrFail($id);
            if ($data->image && file_exists(public_path($data->image))) {
                Helper::fileDelete(public_path($data->image));
            }
            if($data->images){
                foreach ($data->images as $image) {
                    if ($image->image && file_exists(public_path($image->image))) {
                        Helper::fileDelete(public_path($image->image));
                    }
                }
            }
            $data->delete();
            return response()->json([
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

    public function status(int $id): JsonResponse
    {
        $data = Product::findOrFail($id);
        if (!$data) {
            return response()->json([
                'status' => 't-error',
                'message' => 'Item not found.',
            ]);
        }
        $data->status = $data->status === 'active' ? 'inactive' : 'active';
        $data->save();
        return response()->json([
            'status' => 't-success',
            'message' => 'Your action was successful!',
        ]);
    }
}
