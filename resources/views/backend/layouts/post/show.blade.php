@extends('backend.app', ['title' => 'Show Post'])

@section('content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Post</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Post</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card product-sales-main">
                        <div class="card-header border-bottom">
                            <h3 class="card-title mb-0">{{ Str::limit($post->title, 50) }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $post->title }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $post->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Author</th>
                                    <td><a href="{{ route('admin.users.show', $post->user->id) }}">{{ $post->user->name }}</a></td>
                                </tr>
                                <tr>
                                    <th>Content</th>
                                    <td>{{ $post->content }}</td>
                                </tr>
                                <tr>
                                    <th>Image</th>
                                    <td>
                                        <a href="{{ asset($post->image) }}" target="_blank"><img src="{{ asset($post->image ?? 'default/logo.png') }}" alt="" width="100" height="100" class="img-fluid"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $post->created_at ? $post->created_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $post->updated_at ? $post->updated_at : 'N/A' }}</td>
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