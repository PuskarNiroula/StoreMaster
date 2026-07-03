$(document).ready(function () {


        let topSoldChart = null;
    let revenueChart = null;
    let salesHistogramChart = null;

    // Load Total Revenue by Category (Pie Chart)
    function loadRevenueByCategory() {
        $.ajax({
            url: '/revenueByCategory',
            type: 'GET',
            success: function (response) {
                const categories = Object.keys(response);
                const revenues = Object.values(response);

                const ctx = document.getElementById('revenuePieChart').getContext('2d');

                if (revenueChart) {
                    revenueChart.data.labels = categories;
                    revenueChart.data.datasets[0].data = revenues;
                    revenueChart.update();
                } else {
                    revenueChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: categories,
                            datasets: [{
                                label: 'Revenue by Category',
                                data: revenues,
                                backgroundColor: [
                                    '#007bff', '#28a745', '#ffc107',
                                    '#dc3545', '#6f42c1', '#17a2b8'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                title: {
                                    display: true,
                                    text: 'Total Revenue by Category'
                                }
                            }
                        }
                    });
                }
            },
            error: function (error) {
                console.error('Error loading revenue data:', error);
            }
        });
    }

    // Load Top Sold Items (Bar Chart) — by unit or revenue
   function loadTopSoldItems(type) {
    const url = type == 'revenue' ? '/topSoldItemsByRevenue' : '/topSoldItemsByUnit';

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            const labels = response.map(item => item.product_name);
            const data = response.map(item => type === 'revenue' ? item.total_revenue : item.units_sold);

            const ctx = document.getElementById('topSoldItemsBarChart').getContext('2d');

            if (topSoldChart) {
                topSoldChart.data.labels = labels;
                topSoldChart.data.datasets[0].data = data;
                topSoldChart.data.datasets[0].label = type === 'revenue' ? 'Revenue Earned' : 'Units Sold';
                topSoldChart.update();
            } else {
                topSoldChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: type === 'revenue' ? 'Revenue Earned' : 'Units Sold',
                            data: data,
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: type === 'revenue' ? 'Revenue (₹)' : 'Units Sold'
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        }
                    }
                });
            }
        },
        error: function (err) {
            console.error('Error fetching top sold items:', err);
        }
    });
}



//line graph
function loadMonthlySales(topType) {
    let url;
    switch (topType){
        case "this_year":
            url = "/total-sales-per-month";
            break;
        case "this_month":
            url = "/get-monthly-sales";
            break;
        case "this_week":
            url = "/get-weekly-sales";
            break;
        case "today":
            url = "/get-daily-sales";
            break;
        default:
            url = "/total-sales-per-month";
            break;
    }

    $.ajax({
        url: url,
        type: 'GET',

        success: function (response) {
            let labels = [], totalSales = [];

            switch (topType) {
                case 'this_year':
                    labels = response.map(item => getMonthName(item.month)); // Month name (Jan, Feb, etc.)
                    totalSales = response.map(item => item.total_sales);
                    break;

                case 'this_month':
                    $n=1;
                    labels = response.map(item => 'Week ' + $n++); // Days: Day 1, Day 2, ...
                    totalSales = response.map(item => item.total_sales);
                    break;

                case 'this_week':
    // 1. Define fixed week labels (Sunday to Saturday)
    const allWeekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const salesByDay = {};

    // 2. Initialize all days with 0 sales
    allWeekDays.forEach(day => {
        salesByDay[day] = 0;
    });

    // 3. Fill actual sales from response
    response.forEach(item => {
        const dayLabel = formatDayOfWeek(item.date); // Convert date to weekday (e.g., 'Mon')
        salesByDay[dayLabel] = item.total_sales;
    });

    // 4. Extract final labels and values (in order)
    labels = allWeekDays;
    totalSales = allWeekDays.map(day => salesByDay[day]);
    break;

            }

            const ctx = document.getElementById('monthlySalesHistogram').getContext('2d');

// Create gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, "rgba(54, 185, 204, 0.45)");
            gradient.addColorStop(1, "rgba(54, 185, 204, 0)");

            if (salesHistogramChart) {

                salesHistogramChart.data.labels = labels;
                salesHistogramChart.data.datasets[0].data = totalSales;
                salesHistogramChart.update();

            } else {

                salesHistogramChart = new Chart(ctx, {
                    type: 'line',

                    data: {
                        labels: labels,

                        datasets: [{
                            label: 'Sales',

                            data: totalSales,

                            borderColor: '#36b9cc',
                            backgroundColor: gradient,

                            borderWidth: 3,

                            fill: true,

                            tension: 0.45,

                            pointRadius: 5,
                            pointHoverRadius: 8,

                            pointBackgroundColor: '#36b9cc',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,

                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#36b9cc'
                        }]
                    },

                    options: {

                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            mode: 'index',
                            intersect: false
                        },

                        animation: {
                            duration: 1200,
                            easing: 'easeOutQuart'
                        },

                        scales: {

                            x: {

                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: '#666'
                                }
                            },

                            y: {

                                beginAtZero: true,

                                grid: {
                                    color: '#e9ecef',
                                    borderDash: [5, 5]
                                },

                                ticks: {
                                    color: '#666',
                                    callback: function(value) {
                                        return 'Rs. ' + value.toLocaleString();
                                    }
                                },

                                title: {
                                    display: true,
                                    text: 'Sales Amount'
                                }
                            }
                        },

                        plugins: {

                            legend: {
                                display: false
                            },

                            tooltip: {

                                backgroundColor: '#fff',
                                titleColor: '#000',
                                bodyColor: '#333',
                                borderColor: '#ddd',
                                borderWidth: 1,
                                padding: 12,

                                callbacks: {
                                    label: function(context) {
                                        return ' Rs. ' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        },

        error: function (error) {
            console.log('Error fetching sales data:', error);
        }
    });
}


    // Utility function to get month name
    function getMonthName(monthNumber) {
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        return monthNames[monthNumber - 1];
    }
    function formatDayOfWeek(dateStr) {
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const dayIndex = new Date(dateStr).getDay(); // 0-6
    return days[dayIndex];
}

    // Dropdown change event for Top Sold Type
    $('#top-sold-type').on('change', function () {


        const type = $(this).val(); // unit or revenue
        loadTopSoldItems(type);
    });

    $('#sales-time-period').on('change', function () {


        const topType = $(this).val();

        loadMonthlySales(topType);
    });

    // Initial loads
    loadRevenueByCategory();
    loadTopSoldItems($('#top-sold-type').val() || 'unit');
    loadMonthlySales("this_year");

});
