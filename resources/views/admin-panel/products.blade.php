@extends('layouts.admin.admin')

@section('content')

<div class="card-header text-black text-left">
    <h4>Products</h4>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                All Products
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerProducts as $index => $products)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img width="60" height="60" src="{{ asset('assets/images/'.$products->image) }}" alt="{{ __('Product Image') }}" class="img-thumbnail">
                            </td>
                            <td>{{ $products->id}}</td>
                            <td>{{ $products->name}}</td>
                            <td>
                                {{ $products->description }}
                            </td>
                            <td>
                                {{ $products->price }}
                            </td>
                            <td>{{ $products->type }}</td>

                            <td>
                                <button>
                                    <a href="{{ route('admin.products.update.show', $products->id) }}">
                                        Update
                                    </a>
                                </button>
                            </td>

                            <td>
                                <button>
                                    <a href="{{ route('admin.products.delete', $products->id) }}">
                                        Delete
                                    </a>
                                </button>
                            </td>

                            <td>{{ $products->created_at }}</td>
                        </tr>
                        <!-- Add more orders -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
