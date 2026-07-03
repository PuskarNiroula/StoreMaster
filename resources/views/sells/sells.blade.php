@extends('./layout/layout')
@section('css')
<link rel="stylesheet" href="/css/sales.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="container">

      <div class="topRow">


          <div class="card shadow-sm border-0 mb-4">
              <div class="card-body">

                  <div class="d-flex justify-content-between align-items-center mb-3">
                      <h5 class="card-title mb-0">
                          Total Sales
                      </h5>

                      <select id="sales-time-period"
                              class="form-select form-select-sm"
                              style="width:160px;">
                          <option value="this_week">This Week</option>
                          <option value="this_month" selected>This Month</option>
                      </select>
                  </div>

                  <div style="height:320px;">
                      <canvas id="monthlySalesHistogram"></canvas>
                  </div>

              </div>
          </div>



      </div>
        <div class="row">
        <!-- Total Revenue by Category (Pie Chart) -->
        <div class="hello-world">
            <div class="card-hello">
                <div class="card-body">
                    <canvas id="revenuePieChart" ></canvas>

                </div>
            </div>

    </div>



        <!-- Top 3 Items Sold by Units (Line Graph) -->
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                   <center> <h5 class="card-title">Top 3 Items Sold </h5></center>
                  <select id="top-sold-type" class="form-select mb-3">
    <option value="unit">By Unit</option>
    <option value="revenue">By Revenue</option>
</select>
                </div>
                    <div class="card-body">
                        <canvas id="topSoldItemsBarChart"></canvas>
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
