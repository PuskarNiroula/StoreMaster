@extends('layout.layout')

@section('content')

    <div class="container-fluid py-4">

        <div class="row justify-content-center">

            <div class="col-lg-8 col-md-10">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-warning text-dark border-0 rounded-top-4 py-3">

                        <div class="d-flex align-items-center">

                            <i class="fas fa-box-open fa-2x me-3"></i>

                            <div>

                                <h3 class="mb-0 fw-bold">
                                    Edit Product
                                </h3>

                                <small>
                                    Update product information
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('products.update', $product->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <label class="form-label fw-semibold">
                                        Product Name
                                    </label>

                                    <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-box text-warning"></i>
                                    </span>

                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control form-control-lg"
                                            value="{{ old('name', $product->name) }}"
                                            placeholder="Enter product name"
                                            required>

                                    </div>

                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="col-md-6 mb-4">

                                    <label class="form-label fw-semibold">
                                        Category
                                    </label>

                                    <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-tags text-primary"></i>
                                    </span>

                                        <select
                                            name="category_id"
                                            class="form-select form-select-lg"
                                            required>

                                            @foreach($categories as $category)

                                                <option
                                                    value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>

                                                    {{ $category->name }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    @error('category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <label class="form-label fw-semibold">
                                        Price (Rs.)
                                    </label>

                                    <div class="input-group">

                                    <span class="input-group-text">
                                        Rs.
                                    </span>

                                        <input
                                            type="number"
                                            step="0.01"
                                            name="price"
                                            class="form-control form-control-lg"
                                            value="{{ old('price', $product->price) }}"
                                            placeholder="0.00"
                                            required>

                                    </div>

                                    @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="col-md-6 mb-4">

                                    <label class="form-label fw-semibold">
                                        Stock Quantity
                                    </label>

                                    <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-warehouse text-success"></i>
                                    </span>

                                        <input
                                            type="number"
                                            name="stock_quantity"
                                            class="form-control form-control-lg"
                                            value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                            placeholder="Enter stock quantity"
                                            required>

                                    </div>

                                    @error('stock_quantity')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                            </div>

                            <div class="d-flex justify-content-between mt-4">

                                <a href="{{ route('products.index') }}"
                                   class="btn btn-outline-secondary px-4 py-2">

                                    <i class="fas fa-arrow-left me-2"></i>

                                    Back

                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-warning text-dark px-4 py-2">

                                    <i class="fas fa-save me-2"></i>

                                    Update Product

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
