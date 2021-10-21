<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        $startDate = $request->query('start');
        $endDate = $request->query('end');

        $expenseQuery = Expense::orderBy('date')
            ->with('category');

        if ($startDate && $endDate) {
            $expenseQuery = $expenseQuery->whereBetween('date', [$startDate, $endDate]);
        }

        $expenses = $expenseQuery->get();

        $categories = Category::orderBy('name')->get();

        return inertia('Dashboard', [
            'expenses' => $expenses,
            'categories' => $categories,
        ]);
    }
}
