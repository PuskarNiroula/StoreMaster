@extends('./layout/layout')

@section('content')

    @php
        $progressPercent = $predictedSales > 0
            ? round(($actualSales / $predictedSales) * 100, 2)
            : 0;

        $circumference = 2 * 3.1416 * 45;
        $offset = $circumference - ($circumference * $progressPercent / 100);

        if ($progressPercent >= 90) {
            $status = "Excellent";
            $statusColor = "success";
        } elseif ($progressPercent >= 75) {
            $status = "Good";
            $statusColor = "primary";
        } elseif ($progressPercent >= 50) {
            $status = "Average";
            $statusColor = "warning";
        } else {
            $status = "Poor";
            $statusColor = "danger";
        }
    @endphp

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    <i class="fas fa-chart-pie text-primary me-2"></i>
                    Analytics Dashboard
                </h2>

                <p class="text-muted mb-0">
                    Sales prediction and inventory insights
                </p>

            </div>

        </div>

        <div class="row g-4 mb-4">

            <div class="col-lg-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Predicted Sales
                                </small>

                                <h3 class="fw-bold text-primary mt-2">
                                    Rs. {{ number_format($predictedSales,2) }}
                                </h3>

                            </div>

                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:65px;height:65px;">

                                <i class="fas fa-chart-line fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Stock Alerts
                                </small>

                                <h3 class="fw-bold text-danger mt-2">
                                    {{ $stockAlerts->count() }}
                                </h3>

                            </div>

                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:65px;height:65px;">

                                <i class="fas fa-box-open fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Undemanded Products
                                </small>

                                <h3 class="fw-bold text-warning mt-2">
                                    {{ $undemandedProducts->count() }}
                                </h3>

                            </div>

                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:65px;height:65px;">

                                <i class="fas fa-exclamation-triangle fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-body py-5">

                <div class="row align-items-center">

                    <div class="col-lg-5 text-center">

                        <div style="position:relative;width:220px;height:220px;margin:auto;">

                            <svg width="220" height="220" viewBox="0 0 100 100">

                                <circle
                                    cx="50"
                                    cy="50"
                                    r="45"
                                    stroke="#edf2f7"
                                    stroke-width="8"
                                    fill="none"/>

                                <circle
                                    id="progressCircle"
                                    cx="50"
                                    cy="50"
                                    r="45"
                                    stroke="#4e73df"
                                    stroke-width="8"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $circumference }}"
                                    transform="rotate(-90 50 50)"
                                    style="transition:stroke-dashoffset 1.8s ease;"/>

                            </svg>

                            <div class="position-absolute top-50 start-50 translate-middle text-center">

                                <small class="text-muted d-block">
                                    Progress Percentage
                                </small>

                                <h2 id="progressPercent"
                                    class="fw-bold text-primary mb-0">
                                    0%
                                </h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-7">

                        <h3 class="fw-bold mb-3">
                            Prediction Performance
                        </h3>

                        <p class="text-muted">

                            Compare your predicted sales with the actual sales
                            recorded during the selected period.

                        </p>

                        <div class="row mt-4">

                            <div class="col-md-6 mb-3">

                                <div class="border rounded-4 p-3">

                                    <small class="text-muted">
                                        Predicted Sales
                                    </small>

                                    <h4 class="fw-bold text-primary mt-2">
                                        Rs. {{ number_format($predictedSales,2) }}
                                    </h4>

                                </div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <div class="border rounded-4 p-3">

                                    <small class="text-muted">
                                        Actual Sales
                                    </small>

                                    <h4 class="fw-bold text-success mt-2">
                                        Rs. {{ number_format($actualSales,2) }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                        <span class="badge bg-{{ $statusColor }} fs-6 px-4 py-2">

                        {{ $status }}

                    </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-header bg-danger text-white border-0 rounded-top-4 py-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <h5 class="mb-0">
                                <i class="fas fa-triangle-exclamation me-2"></i>
                                Stock Alerts
                            </h5>

                            <span class="badge bg-light text-danger fs-6">
                        {{ $stockAlerts->count() }}
                    </span>

                        </div>

                    </div>

                    <div class="card-body p-0">

                        @if($stockAlerts->isEmpty())

                            <div class="text-center py-5">

                                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>

                                <h5>No Stock Alerts</h5>

                                <p class="text-muted mb-0">
                                    All products have sufficient stock.
                                </p>

                            </div>

                        @else

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">

                                    <tr>

                                        <th class="ps-4">Product</th>

                                        <th class="text-center">Quantity</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    @foreach($stockAlerts as $product)

                                        <tr>

                                            <td class="ps-4 fw-semibold">

                                                {{ $product->name }}

                                            </td>

                                            <td class="text-center">

                                        <span class="badge bg-danger fs-6">

                                            {{ $product->stock_quantity }}

                                        </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-header bg-warning border-0 rounded-top-4 py-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <h5 class="mb-0 text-dark">

                                <i class="fas fa-box me-2"></i>

                                Undemanded Products

                            </h5>

                            <span class="badge bg-dark">

                        {{ $undemandedProducts->count() }}

                    </span>

                        </div>

                    </div>

                    <div class="card-body p-0">

                        @if($undemandedProducts->isEmpty())

                            <div class="text-center py-5">

                                <i class="fas fa-fire text-success fa-4x mb-3"></i>

                                <h5>Excellent!</h5>

                                <p class="text-muted mb-0">

                                    Every product has been sold recently.

                                </p>

                            </div>

                        @else

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">

                                    <tr>

                                        <th class="ps-4">

                                            Product

                                        </th>

                                        <th class="text-center">

                                            Quantity

                                        </th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    @foreach($undemandedProducts as $product)

                                        <tr>

                                            <td class="ps-4 fw-semibold">

                                                {{ $product->name }}

                                            </td>

                                            <td class="text-center">

                                        <span class="badge bg-secondary fs-6">

                                            {{ $product->stock_quantity }}

                                        </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        document.addEventListener("DOMContentLoaded",function(){

            const circle=document.getElementById("progressCircle");

            const text=document.getElementById("progressPercent");

            const offset={{ $offset }};

            const percent={{ $progressPercent }};

            setTimeout(function(){

                circle.style.strokeDashoffset=offset;

            },300);

            let current=0;

            const timer=setInterval(function(){

                current+=1;

                if(current>=percent){

                    current=percent;

                    clearInterval(timer);

                }

                text.innerHTML=current.toFixed(0)+"%";

            },15);

        });

    </script>

@endsection
