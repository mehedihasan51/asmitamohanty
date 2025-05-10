@extends('backend.app', ['title' => 'Cteate Product'])

@section('content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Product</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row" id="user-profile">
                <div class="col-lg-9">

                    <div class="tab-content">
                        <div class="tab-pane active show" id="editProfile">
                            <div class="card">
                                <div class="card-body border-0">
                                    <form class="form-horizontal" method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-4">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="title" class="form-label">Title:</label>
                                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter here title" id="title" value="{{ $product->title ?? '' }}">
                                                        @error('title')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="price_per_day" class="form-label">Price per day:</label>
                                                        <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" name="price_per_day" placeholder="Enter here price per day" id="price_per_day" value="{{ $product->price_per_day ?? '' }}">
                                                        @error('price_per_day')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="quantity" class="form-label">Quantity:</label>
                                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" placeholder="Enter here quantity" id="quantity" value="{{ $product->quantity ?? '' }}">
                                                        @error('quantity')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="size_id" class="form-label">Size:</label>
                                                        <select class="form-control @error('size_id') is-invalid @enderror" name="size_id" id="size_id">
                                                            <option value="">Select size</option>
                                                            @foreach($sizes as $size)
                                                            <option value="{{ $size->id }}" {{ $product->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('size_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="color_id" class="form-label">Color:</label>
                                                        <select class="form-control @error('color_id') is-invalid @enderror" name="color_id" id="color_id">
                                                            <option value="">Select color</option>
                                                            @foreach($colors as $color)
                                                                <option value="{{ $color->id }}" {{ $product->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('color_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="condition_id" class="form-label">Condition:</label>
                                                        <select class="form-control @error('condition_id') is-invalid @enderror" name="condition_id" id="condition_id">
                                                            <option value="">Select condition</option>
                                                            @foreach($conditions as $condition)
                                                            <option value="{{ $condition->id }}" {{ $product->condition_id == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('condition_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cloth_for_id" class="form-label">Cloth For:</label>
                                                        <select class="form-control @error('cloth_for_id') is-invalid @enderror" name="cloth_for_id" id="cloth_for_id">
                                                            <option value="">Select a Cloth For</option>
                                                            @if(!empty($cloth_fors) && $cloth_fors->count() > 0)
                                                            @foreach($cloth_fors as $cloth_for)
                                                            <option value="{{ $cloth_for->id }}" {{  $product->cloth_for_id == $cloth_for->id ? 'selected' : '' }}>{{ $cloth_for->name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @error('cloth_for_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="category_id" class="form-label">Category:</label>
                                                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                                                            <option value="">Select a Category</option>
                                                            @forelse($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('category_id', isset($product) ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                            @empty
                                                            <option value="" disabled>No categories available</option>
                                                            @endforelse
                                                        </select>
                                                        @error('category_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="measurement_id" class="form-label">Body Measurement:</label>
                                                        <select class="form-control @error('measurement_id') is-invalid @enderror" name="measurement_id" id="measurement_id">
                                                            <option value="">Select a Category ID</option>
                                                            @if(!empty($measurements) && $measurements->count() > 0)
                                                            @foreach($measurements as $measurement)
                                                            <option value="{{ $measurement->id }}" {{ $product->measurement_id == $measurement->id ? 'selected' : '' }}>{{ $measurement->name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @error('measurement_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description" class="form-label">Description:</label>
                                                        <textarea class="summernote form-control @error('description') is-invalid @enderror " name="description" id="description" placeholder="Enter here description" rows="2">{{ $product->description ?? '' }}</textarea>
                                                        @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="highlights" class="form-label">Highlights:</label>
                                                        <textarea class="summernote form-control @error('highlights') is-invalid @enderror " name="highlights" id="highlights" placeholder="Enter here highlights" rows="2">{{ $product->highlights ?? '' }}</textarea>
                                                        @error('highlights')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="thumb" class="form-label">Thumb:</label>
                                                        <input type="file" data-default-file="{{ $product->thumb && file_exists(public_path($product->thumb)) ? url($product->thumb) : url('default/logo.png') }}" class="dropify form-control @error('thumb') is-invalid @enderror" name="thumb" id="thumb">
                                                        @error('thumb')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="images" class="form-label">Images:</label>
                                                        <input type="file" class="dropify form-control @error('images') is-invalid @enderror" name="images[]" id="images" multiple>
                                                        @error('images')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row" id="image_load"></div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@push('scripts')
<script>
    function imagesLoad(product_id) {
        $('#image_load').empty();
        $.ajax({
            url: `{{ route('admin.image.index', ':product_id') }}`.replace(':product_id', product_id),
            type: 'GET',
            success: function(resp) {
                let html = '';
                $.each(resp.data.images, function(key, image) {
                    let image_src = image.image ? "{{ asset('') }}/" + image.image : '{{ asset("default/logo.png") }}';
                    html += `<div class="col-md-6" >
                                <div class="position-relative">
                                    <img src="` + image_src + `" alt="product image" class="img-fluid img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                    <i class="fa fa-trash position-absolute top-0 start-0 text-danger bg-white p-1 rounded" style="cursor: pointer;" onclick="deleteImage(` + image.id + `)"></i>
                                </div>
                            </div>`;
                });
                $('#image_load').html(html);
            },
            error: function(resp) {
                $('#image_load').html(resp.message);
            }
        });
    }

    imagesLoad(`{{ $product->id }}`);

    function deleteImage(imageId) {
        if (confirm("Are you sure you want to delete this image?")) {
            NProgress.start();
            $.ajax({
                url: `{{ route('admin.image.destroy', ':id') }}`.replace(':id', imageId),
                type: 'GET',
                success: function(resp) {
                    NProgress.done();
                    imagesLoad(resp.product_id);
                    toastr.success(resp.message);
                },
                error: function(resp) {
                    NProgress.done();
                    toastr.error(resp.message);
                }
            });
        }
    }
</script>
@endpush