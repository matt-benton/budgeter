<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        if ($request->query('start') && $request->query('end')) {
            $startDate = $request->query('start');
            $endDate = $request->query('end');
        } else {
            $now = Carbon::now();
            $startDate = $now->startOfMonth()->toDateString();
            $endDate = $now->endOfMonth()->toDateString();
        }

        $expenses = Expense::orderBy('date')
            ->with('category')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $categories = Category::orderBy('name')->get();

        return inertia('Dashboard', [
            'expenses' => $expenses,
            'categories' => $categories,
        ]);
    }
}
