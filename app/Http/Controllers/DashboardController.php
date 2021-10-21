<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $expenses = Expense::with('category')->get();

        return inertia('Dashboard',
            ['expenses' => $expenses]
        );
    }
}
