@extends('backend.app', ['title' => 'Show Product'])

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
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card product-sales-main">
                        <div class="card-header border-bottom">
                            <h3 class="card-title mb-0">{{ Str::limit($product->title, 50) }}</h3>
                            <div class="card-options ms-auto">
                                <a href="{{ route('admin.product.package.index', $product->id) }}" class="btn btn-primary btn-sm">Packages</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $product->title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $product->slug ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Author</th>
                                    <td><a href="{{ route('admin.users.show', $product->user->id) }}">{{ $product->user->name }}</a></td>
                                </tr>
                                <tr>
                                    <th>Price Per Day</th>
                                    <td>{{ $product->price_per_day.' $' }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td>{{ $product->quantity ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Size</th>
                                    <td>{{ $product->size->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Color</th>
                                    <td>{{ $product->color->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Condition</th>
                                    <td>{{ $product->condition->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Cloth For</th>
                                    <td>{{ $product->clothFor->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td> <a href="{{ route('admin.category.show', $product->category->id) }}">{{ $product->category->name }}</a></td>
                                </tr>
                                <tr>
                                    <th>Measurement</th>
                                    <td>{{ $product->measurement->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Thumb</th>
                                    <td>
                                        <a href="{{ asset($product->thumb) }}" target="_blank"><img src="{{ asset($product->thumb ?? 'default/logo.png') }}" alt="" width="100" height="100" class="img-fluid"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Images</th>
                                    <td>
                                        @if($product->images)
                                        @foreach ($product->images as $image)
                                        <a href="{{ asset($image->image) }}" target="_blank"><img src="{{ asset($image->image) }}" class="img-fluid" alt="product image" width="100" height="100"></a>
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{!! $product->description ?? 'N/A' !!}</td>
                                </tr>
                                <tr>
                                    <th>Highlights</th>
                                    <td>{!! $product->highlights ?? 'N/A' !!}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $product->created_at ? $product->created_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $product->updated_at ? $product->updated_at : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><!-- COL END -->
            </div>

        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@push('scripts')

@endpush