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
                <div class="col-lg-12">

                    <div class="tab-content">
                        <div class="tab-pane active show" id="editProfile">
                            <div class="card">
                                <div class="card-body border-0">
                                    <form class="form-horizontal" method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-4">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="title" class="form-label">Title:</label>
                                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter here title" id="title" value="{{ old('title') }}">
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
                                                        <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" name="price_per_day" placeholder="Enter here price per day" id="price_per_day" value="{{ old('price_per_day') }}">
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
                                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" placeholder="Enter here quantity" id="quantity" value="{{ old('quantity') }}">
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
                                                                <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
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
                                                                <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
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
                                                                <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
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
                                                            <option value="{{ $cloth_for->id }}" {{ old('cloth_for_id') == $cloth_for->id ? 'selected' : '' }}>{{ $cloth_for->name }}</option>
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
                                                            <option value="">Select a Category ID</option>
                                                            @if(!empty($categories) && $categories->count() > 0)
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (old('category_id') !== null && old('category_id') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                            @endif
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
                                                            <option value="{{ $measurement->id }}" {{ old('measurement_id') == $measurement->id ? 'selected' : '' }}>{{ $measurement->name }}</option>
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
                                                        <textarea class="summernote form-control @error('description') is-invalid @enderror " name="description" id="description" placeholder="Enter here description" rows="2">{{ old('description') }}</textarea>
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
                                                        <textarea class="summernote form-control @error('highlights') is-invalid @enderror " name="highlights" id="highlights" placeholder="Enter here highlights" rows="2">{{ old('highlights') }}</textarea>
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
                                                        <input type="file" class="dropify form-control @error('thumb') is-invalid @enderror" name="thumb" id="thumb">
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
            </div>

        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@push('scripts')

@endpush