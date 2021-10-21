<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $expenses = Expense::orderBy('date')->with('category')->get();
        $categories = Category::orderBy('name')->get();

        return inertia('Dashboard', [
            'expenses' => $expenses,
            'categories' => $categories,
        ]);
    }
}
