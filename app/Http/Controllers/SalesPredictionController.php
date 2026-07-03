<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SalesPredictionController extends Controller
{
     public function predictNextMonthSales():float{
    $now = Carbon::now();

    $salesData = DB::table('bills')
        ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as total_sales')
        ->where('created_at', '>=', $now->copy()->subMonths(15)->startOfMonth())
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

         if ($salesData->count() < 3) {
             return round($salesData->avg('total_sales'), 2);
         }


    $x = [];
    $y = [];

    $startMonth = $now->copy()->subMonths(14)->startOfMonth();

    $salesMap = $salesData->mapWithKeys(function ($item) {
        return [sprintf('%04d-%02d', $item->year, $item->month) => $item->total_sales];
    });

    for ($i = 0; $i < 15; $i++) {
        $month = $startMonth->copy()->addMonths($i);
        $key = $month->format('Y-m');

        $x[] = $i + 1;
        $y[] = $salesMap->get($key, 0);
    }

    $n = count($x);
    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;

    $numerator = 0;
    $denominator = 0;
    for ($i = 0; $i < $n; $i++) {
        $numerator += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $denominator += ($x[$i] - $meanX) ** 2;
    }
    $m = $numerator / $denominator;
    $b = $meanY - $m * $meanX;

    $nextMonthIndex = 16;
    $predictedSales = $m * $nextMonthIndex + $b;



    return round($predictedSales,2);
}



}


