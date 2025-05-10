@extends('backend.app', ['title' => 'Show Package'])

@section('content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Package</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Package</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card package-sales-main">
                        <div class="card-header border-bottom">
                            <h3 class="card-title mb-0">{{ Str::limit($package->name, 50) }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Package Name</th>
                                    <td>{{ $package->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Product Title</th>
                                    <td><a href="{{ route('admin.product.show', $package->product->id) }}">{{ $package->product->title }}</a></td>
                                </tr>
                                <tr>
                                    <th>Day</th>
                                    <td>{{ $package->day ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ $package->price_per_day ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>{{ $package->total_price ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ $package->type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Recommended</th>
                                    <td>{{ $package->recommended ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $package->created_at ? $package->created_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $package->updated_at ? $package->updated_at : 'N/A' }}</td>
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