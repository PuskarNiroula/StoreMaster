@extends('./layout/layout')
@section('css')
<link rel="stylesheet" href="/css/sales.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-xl-8 col-lg-7 mb-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="fas fa-chart-line text-primary me-2"></i>
                                    Sales Overview
                                </h4>

                                <small class="text-muted">
                                    Sales performance over time
                                </small>
                            </div>

                            <select
                                id="sales-time-period"
                                class="form-select"
                                style="width:180px">

                                <option value="this_week">
                                    This Week
                                </option>

                                <option value="this_month" selected>
                                    This Month
                                </option>

                            </select>

                        </div>

                        <div style="height:380px">

                            <canvas id="monthlySalesHistogram"></canvas>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-4 col-lg-5 mb-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-body">

                        <h4 class="fw-bold text-center mb-1">
                            Revenue by Category
                        </h4>

                        <p class="text-center text-muted mb-4">
                            Category contribution
                        </p>

                        <div style="height:403px">

                            <canvas id="revenuePieChart"></canvas>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-12">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>

                                <h4 class="fw-bold mb-1">
                                    <i class="fas fa-crown text-warning me-2"></i>
                                    Top Selling Products
                                </h4>

                                <small class="text-muted">
                                    Compare best selling products
                                </small>

                            </div>

                            <select
                                id="top-sold-type"
                                class="form-select"
                                style="width:180px">

                                <option value="unit">
                                    By Units Sold
                                </option>

                                <option value="revenue">
                                    By Revenue
                                </option>

                            </select>

                        </div>

                        <div style="height:400px">

                            <canvas id="topSoldItemsBarChart"></canvas>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script  src="{{ asset('/js/sales.js') }}">

</script>

@endsection
