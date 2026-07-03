@extends('./layout/layout')

@section('content')

    <div class="container-fluid py-4">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-warning text-dark border-0 rounded-top-4 py-3">

                        <div class="d-flex align-items-center">

                            <i class="fas fa-edit fa-2x me-3"></i>

                            <div>

                                <h3 class="mb-0 fw-bold">
                                    Edit Category
                                </h3>

                                <small>
                                    Update category information
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('category.update', $category->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Category Name

                                </label>

                                <div class="input-group">

                                <span class="input-group-text bg-light">

                                    <i class="fas fa-folder-open text-warning"></i>

                                </span>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control form-control-lg"
                                        value="{{ old('name', $category->name) }}"
                                        placeholder="Enter category name..."
                                        required>

                                </div>

                                @error('name')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                                @enderror

                            </div>

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('category.index') }}"
                                   class="btn btn-outline-secondary px-4">

                                    <i class="fas fa-arrow-left me-2"></i>

                                    Back

                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-warning text-dark px-4">

                                    <i class="fas fa-save me-2"></i>

                                    Update Category

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
