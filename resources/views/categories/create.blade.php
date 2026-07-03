@extends('./layout/layout')

@section('css')


    body{
    background:#f5f7fb;
    font-family:'Inter',sans-serif;
    }

    .card{
    border:none;
    border-radius:20px;
    transition:.3s;
    }

    .card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 40px rgba(0,0,0,.08)!important;
    }

    .card-header{
    border-bottom:none;
    }

    .form-control{
    border-radius:10px;
    padding:12px 15px;
    }

    .form-control:focus{
    box-shadow:0 0 0 .2rem rgba(78,115,223,.15);
    border-color:#4e73df;
    }

    .input-group-text{
    border-radius:10px 0 0 10px;
    }

    .btn{
    border-radius:10px;
    padding:10px 22px;
    font-weight:600;
    transition:.3s;
    }

    .btn:hover{
    transform:translateY(-2px);
    }

    .form-label{
    color:#4a5568;
    }

    .card-header{
    background:linear-gradient(135deg,#4e73df,#36b9cc)!important;
    }
@endsection

@section('content')

    <div class="container-fluid py-4">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-primary text-white border-0 rounded-top-4 py-3">

                        <div class="d-flex align-items-center">

                            <i class="fas fa-folder-plus fa-2x me-3"></i>

                            <div>

                                <h3 class="mb-0 fw-bold">
                                    Create Category
                                </h3>

                                <small>
                                    Add a new product category
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('category.store') }}" method="POST">

                            @csrf

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Category Name

                                </label>

                                <div class="input-group">

                                <span class="input-group-text bg-light">

                                    <i class="fas fa-folder text-primary"></i>

                                </span>

                                    <input
                                        type="text"
                                        class="form-control form-control-lg"
                                        name="name"
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
                                    class="btn btn-primary px-4">

                                    <i class="fas fa-save me-2"></i>

                                    Save Category

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
