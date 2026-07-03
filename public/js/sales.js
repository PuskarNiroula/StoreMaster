$(function () {

    let salesChart = null;
    let revenueChart = null;
    let topSoldChart = null;

    const COLORS = {
        blue: "#4e73df",
        green: "#1cc88a",
        cyan: "#36b9cc",
        yellow: "#f6c23e",
        red: "#e74a3b",
        purple: "#6f42c1",
        orange: "#fd7e14",
        gray: "#858796"
    };

    function currency(value) {

        value = Number(value);

        if (value >= 10000000)
            return "Rs. " + (value / 10000000).toFixed(1) + " Cr";

        if (value >= 100000)
            return "Rs. " + (value / 100000).toFixed(1) + " L";

        if (value >= 1000)
            return "Rs. " + (value / 1000).toFixed(1) + " K";

        return "Rs. " + value.toLocaleString();
    }

    function monthName(month) {

        const months = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        return months[month - 1];
    }

    function weekday(date) {

        return ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"][new Date(date).getDay()];

    }

    function gradient(ctx) {

        const g = ctx.createLinearGradient(0, 0, 0, 350);

        g.addColorStop(0, "rgba(78,115,223,.45)");
        g.addColorStop(.5, "rgba(78,115,223,.15)");
        g.addColorStop(1, "rgba(78,115,223,0)");

        return g;

    }

    function loadMonthlySales(period) {

        let url = "";

        switch (period) {

            case "this_week":
                url = "/get-weekly-sales";
                break;

            case "this_month":
                url = "/get-monthly-sales";
                break;

            case "today":
                url = "/get-daily-sales";
                break;

            case "this_year":
            default:
                url = "/total-sales-per-month";
                break;
        }

        $.ajax({

            url: url,
            type: "GET",

            beforeSend: function () {

                $("#monthlySalesHistogram")
                    .css({
                        opacity: .4,
                        transition: ".3s"
                    });

            },

            success: function (response) {

                let labels = [];
                let values = [];

                if (period === "this_year") {

                    labels = response.map(item => monthName(item.month));
                    values = response.map(item => Number(item.total_sales));

                }

                if (period === "this_month") {

                    let week = 1;

                    labels = response.map(() => "Week " + week++);
                    values = response.map(item => Number(item.total_sales));

                }

                if (period === "this_week") {

                    const days = [
                        "Sun",
                        "Mon",
                        "Tue",
                        "Wed",
                        "Thu",
                        "Fri",
                        "Sat"
                    ];

                    const sales = {};

                    days.forEach(day => sales[day] = 0);

                    response.forEach(item => {

                        sales[weekday(item.date)] = Number(item.total_sales);

                    });

                    labels = days;

                    values = days.map(day => sales[day]);

                }

                if (period === "today") {

                    labels = response.map(item => item.hour + ":00");
                    values = response.map(item => Number(item.total_sales));

                }

                const ctx = document
                    .getElementById("monthlySalesHistogram")
                    .getContext("2d");

                if (salesChart) {

                    salesChart.data.labels = labels;
                    salesChart.data.datasets[0].data = values;

                    salesChart.update();

                } else {

                    salesChart = new Chart(ctx, {

                        type: "line",

                        data: {

                            labels: labels,

                            datasets: [

                                {

                                    label: "Sales",

                                    data: values,

                                    borderColor: COLORS.blue,

                                    backgroundColor: gradient(ctx),

                                    fill: true,

                                    borderWidth: 4,

                                    cubicInterpolationMode: "monotone",

                                    tension: .45,

                                    pointRadius: 5,

                                    pointHoverRadius: 9,

                                    pointBackgroundColor: "#ffffff",

                                    pointBorderColor: COLORS.blue,

                                    pointBorderWidth: 3,

                                    pointHoverBorderWidth: 4,

                                    pointHoverBackgroundColor: COLORS.blue

                                }

                            ]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            animation: {

                                duration: 1200,

                                easing: "easeOutQuart"

                            },

                            interaction: {

                                intersect: false,

                                mode: "index"

                            },

                            layout: {

                                padding: 15

                            },

                            elements: {

                                line: {

                                    borderJoinStyle: "round"

                                }

                            },

                            scales: {

                                x: {

                                    grid: {

                                        display: false

                                    },

                                    ticks: {

                                        color: "#6c757d",

                                        font: {

                                            size: 13,

                                            weight: "600"

                                        }

                                    }

                                },

                                y: {

                                    beginAtZero: true,

                                    grace: "10%",

                                    grid: {

                                        color: "#eef2f7",

                                        drawBorder: false

                                    },

                                    ticks: {

                                        maxTicksLimit: 6,

                                        color: "#6c757d",

                                        callback: function (value) {

                                            return currency(value);

                                        }

                                    }

                                }

                            },

                            plugins: {

                                legend: {

                                    display: false

                                },

                                tooltip: {

                                    backgroundColor: "#ffffff",

                                    titleColor: "#222",

                                    bodyColor: "#444",

                                    borderColor: "#dddddd",

                                    borderWidth: 1,

                                    padding: 12,

                                    displayColors: false,

                                    callbacks: {

                                        label: function (context) {

                                            return "Sales : " + currency(context.parsed.y);

                                        }

                                    }

                                }

                            }

                        }

                    });

                }

            },

            complete: function () {

                $("#monthlySalesHistogram")
                    .css("opacity", 1);

            },

            error: function () {

                console.log("Unable to load sales.");

            }

        });

    }

    function loadTopSoldItems(type) {

        const url = type === "revenue"
            ? "/topSoldItemsByRevenue"
            : "/topSoldItemsByUnit";

        $.ajax({

            url: url,
            type: "GET",

            beforeSend: function () {

                $("#topSoldItemsBarChart")
                    .css({
                        opacity: .4,
                        transition: ".3s"
                    });

            },

            success: function (response) {

                const labels = response.map(item => item.product_name);

                const values = response.map(item =>
                    type === "revenue"
                        ? Number(item.total_revenue)
                        : Number(item.units_sold)
                );

                const ctx = document
                    .getElementById("topSoldItemsBarChart")
                    .getContext("2d");

                const barGradient = ctx.createLinearGradient(0,0,0,350);

                barGradient.addColorStop(0,"#4e73df");
                barGradient.addColorStop(.5,"#36b9cc");
                barGradient.addColorStop(1,"#1cc88a");

                if(topSoldChart){

                    topSoldChart.data.labels = labels;

                    topSoldChart.data.datasets[0].data = values;

                    topSoldChart.data.datasets[0].label =
                        type==="revenue"
                            ? "Revenue"
                            : "Units Sold";

                    topSoldChart.update();

                }else{

                    topSoldChart = new Chart(ctx,{

                        type:"bar",

                        data:{

                            labels:labels,

                            datasets:[{

                                label:type==="revenue"
                                    ? "Revenue"
                                    : "Units Sold",

                                data:values,

                                backgroundColor:barGradient,

                                borderRadius:15,

                                borderSkipped:false,

                                hoverBorderWidth:2,

                                hoverBorderColor:"#ffffff",

                                maxBarThickness:45

                            }]

                        },

                        options:{

                            responsive:true,

                            maintainAspectRatio:false,

                            animation:{

                                duration:1400,

                                easing:"easeOutBounce"

                            },

                            layout:{

                                padding:20

                            },

                            plugins:{

                                legend:{
                                    display:false
                                },

                                tooltip:{

                                    backgroundColor:"#fff",

                                    titleColor:"#111",

                                    bodyColor:"#333",

                                    borderColor:"#ddd",

                                    borderWidth:1,

                                    displayColors:false,

                                    callbacks:{

                                        label:function(context){

                                            if(type==="revenue")
                                                return currency(context.parsed.y);

                                            return context.parsed.y+" Units";

                                        }

                                    }

                                }

                            },

                            scales:{

                                x:{

                                    grid:{
                                        display:false
                                    },

                                    ticks:{

                                        color:"#666",

                                        font:{
                                            weight:"600"
                                        }

                                    }

                                },

                                y:{

                                    beginAtZero:true,

                                    grace:"10%",

                                    grid:{

                                        color:"#edf2f7",

                                        drawBorder:false

                                    },

                                    ticks:{

                                        color:"#666",

                                        callback:function(value){

                                            return type==="revenue"
                                                ? currency(value)
                                                : value;

                                        }

                                    }

                                }

                            }

                        }

                    });

                }

            },

            complete:function(){

                $("#topSoldItemsBarChart").css("opacity",1);

            },

            error:function(){

                console.log("Unable to load top sold items.");

            }

        });
    }

    function loadRevenueByCategory() {

        $.ajax({

            url: "/revenueByCategory",
            type: "GET",

            beforeSend: function () {

                $("#revenuePieChart").css({
                    opacity: .4,
                    transition: ".3s"
                });

            },

            success: function (response) {

                const labels = Object.keys(response);

                const values = Object.values(response).map(Number);

                const total = values.reduce((a, b) => a + b, 0);

                const ctx = document
                    .getElementById("revenuePieChart")
                    .getContext("2d");

                const colors = [
                    "#4e73df",
                    "#1cc88a",
                    "#36b9cc",
                    "#f6c23e",
                    "#e74a3b",
                    "#6f42c1",
                    "#fd7e14",
                    "#20c997"
                ];

                const centerTextPlugin = {

                    id: "centerText",

                    afterDraw(chart) {

                        const {ctx} = chart;

                        const meta = chart.getDatasetMeta(0);

                        if (!meta.data.length) return;

                        const x = meta.data[0].x;
                        const y = meta.data[0].y;

                        ctx.save();

                        ctx.textAlign = "center";

                        ctx.fillStyle = "#666";
                        ctx.font = "600 13px Inter";
                        ctx.fillText("Total Revenue", x, y - 10);

                        ctx.fillStyle = "#111";
                        ctx.font = "bold 18px Inter";
                        ctx.fillText(currency(total), x, y + 18);

                        ctx.restore();

                    }

                };

                if (revenueChart) {

                    revenueChart.data.labels = labels;
                    revenueChart.data.datasets[0].data = values;
                    revenueChart.update();

                } else {

                    revenueChart = new Chart(ctx, {

                        type: "doughnut",

                        data: {

                            labels: labels,

                            datasets: [{

                                data: values,

                                backgroundColor: colors,

                                hoverOffset: 15,

                                borderWidth: 4,

                                borderColor: "#ffffff"

                            }]

                        },

                        plugins: [centerTextPlugin],

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            cutout: "70%",

                            animation: {

                                animateRotate: true,
                                animateScale: true,

                                duration: 1500

                            },

                            plugins: {

                                legend: {

                                    position: "bottom",

                                    labels: {

                                        usePointStyle: true,

                                        pointStyle: "circle",

                                        padding: 20,

                                        font: {

                                            size: 13,

                                            weight: "600"

                                        }

                                    }

                                },

                                tooltip: {

                                    backgroundColor: "#fff",

                                    titleColor: "#111",

                                    bodyColor: "#444",

                                    borderColor: "#ddd",

                                    borderWidth: 1,

                                    displayColors: true,

                                    callbacks: {

                                        label(context) {

                                            const value = context.parsed;

                                            const percent = ((value / total) * 100).toFixed(1);

                                            return `${context.label}: ${currency(value)} (${percent}%)`;

                                        }

                                    }

                                }

                            }

                        }

                    });

                }

            },

            complete: function () {

                $("#revenuePieChart").css("opacity", 1);

            },

            error: function () {

                console.log("Unable to load revenue chart.");

            }

        });

    }
    $('#sales-time-period').on('change', function () {
        loadMonthlySales($(this).val());
    });

    $('#top-sold-type').on('change', function () {
        loadTopSoldItems($(this).val());
    });

    loadMonthlySales($('#sales-time-period').val());
    loadTopSoldItems($('#top-sold-type').val());
    loadRevenueByCategory();
});
