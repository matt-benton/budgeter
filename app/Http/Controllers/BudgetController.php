<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetCategoryAmount;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('budgets/Budgets')->with(['budgets' => Budget::orderBy('name')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('budgets/CreateBudget')->with(['categories' => Category::orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $budget = new Budget;
        $budget->name = $request->input('name');
        $budget->save();

        foreach ($request->input('budget_category_amounts') as $amount) {
            if ($amount['amount']) {
                BudgetCategoryAmount::create([
                    'budget_id' => $budget->id,
                    'category_id' => $amount['category_id'],
                    'amount' => $amount['amount'],
                ]);
            }
        }

        return redirect('/budgets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $budget = Budget::where('id', $id)->with('budgetCategoryAmounts.category')->first();

        return inertia('budgets/ShowBudget')->with(['budget' => $budget]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
