@extends('layouts.admin.admin')


@section('content')

<div class="card-header text-black text-left">
    <h4>Update Product</h4>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                @foreach ($products as $product)
                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Add this to allow for PUT request -->

                    <!-- Image Upload -->
                    <div class="form-outline mb-4 mt-4">
                        <label for="product_image">{{ __('Image (Leave blank to keep current)') }}</label>
                        <input type="file" name="product_image" class="form-control">
                    </div>

                    <!-- Product Name -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" class="form-control" placeholder="Enter product name" value="{{ old('name', $product->name) }}" required />
                    </div>

                    <!-- Product Description -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="description" class="form-control" placeholder="Enter product description" value="{{ old('description', $product->description) }}" required />
                    </div>

                    <!-- Product Price -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="price" class="form-control" placeholder="Enter product price" value="{{ old('price', $product->price) }}" required />
                    </div>

                    <!-- Product Type Dropdown -->
                    <label for="product_type">{{ __('Choose Product Type') }}</label>
                    <select class="form-control" name="type" required>
                        <option value="" disabled selected>{{ __('Choose type') }}</option>
                        <option value="Drink" {{ $product->type == 'Drink' ? 'selected' : '' }}>{{ __('Drink') }}</option>
                        <option value="Dessert" {{ $product->type == 'Dessert' ? 'selected' : '' }}>{{ __('Dessert') }}</option>
                    </select>

                    <br>

                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">{{ __('Update') }}</button>
                </form>
                @endforeach
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

@endsection
