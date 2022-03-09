<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

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

        // go to the start of month before subtracting due to carbon weirdness
        $endOfLastMonth = $endDate->startOfMonth()->subMonth()->endOfMonth();
        $startOfThreeMonthsAgo = $endOfLastMonth->startOfMonth()->subMonths(2);

        $categories = Expense::select(
                'categories.id',
                'categories.name',
                DB::raw('round(sum(expenses.amount) / 3) as three_month_avg')
            )
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->whereBetween('date', [$startOfThreeMonthsAgo->toDateString(), $endOfLastMonth->toDateString()])
            ->groupBy('categories.id')
            ->orderBy('categories.name')
            ->get();

        return inertia('Dashboard', [
            'expenses' => $expenses,
            'categories' => $categories,
            'budgets' => Budget::orderBy('name')->with('budgetCategoryAmounts')->get(),
        ]);
    }
}
