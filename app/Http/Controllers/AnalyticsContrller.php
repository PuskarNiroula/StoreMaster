<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsContrller extends Controller
{


public function analyticsDashboard()
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Actual sales this month
    $actualSales = DB::table('bills')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->sum('total_amount');


    $sales=new SalesPredictionController;
    $predictedSales = $sales->predictNextMonthSales();

    $stockAlerts = DB::table('products')
        ->where('stock_quantity', '<', 10)
        ->get();

    $thirtyDaysAgo = Carbon::now()->subDays(30);

    // Get IDs of products sold in last 30 days
    $soldProductIds = DB::table('bills')
        ->join('bill_items', 'bills.id', '=', 'bill_items.bill_id')
        ->where('bills.created_at', '>=', $thirtyDaysAgo)
        ->pluck('bill_items.product_id')
        ->unique();

    // Get products NOT sold in last 30 days
    $undemandedProducts = DB::table('products')
        ->whereNotIn('id', $soldProductIds)
        ->get();

    return view('analytics.index', compact(
        'actualSales',
        'predictedSales',
        'stockAlerts',
        'undemandedProducts'
    ));
}

}
