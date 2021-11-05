<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\CarbonImmutable;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        if ($request->query('start') && $request->query('end')) {
            $startDate = new CarbonImmutable($request->query('start'));
            $endDate = new CarbonImmutable($request->query('end'));
        } else {
            $now = CarbonImmutable::now();
            $startDate = $now->startOfMonth();
            $endDate = $now->endOfMonth();
        }

        $expenses = Expense::orderBy('date')
            ->with('category')
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->get();

        $categories = Category::orderBy('name')->get();

        foreach ($categories as $category) {
            $category->three_month_avg = $category->getThreeMonthAvg($endDate->subMonths(1));
        }

        return inertia('Dashboard', [
            'expenses' => $expenses,
            'categories' => $categories,
        ]);
    }
}
