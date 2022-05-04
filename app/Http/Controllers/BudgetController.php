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
            if (is_numeric($amount['amount'])) {
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
        $budgetCategoryAmounts = BudgetCategoryAmount::join('categories', 'categories.id', '=', 'budget_category_amounts.category_id')
            ->join('budgets', 'budgets.id', '=', 'budget_category_amounts.budget_id')
            ->select(
                'categories.id as category_id',
                'categories.name',
                'budgets.name as budget_name',
                'budget_category_amounts.amount',
                'budget_category_amounts.budget_id',
            )
            ->having('budget_category_amounts.budget_id', $id)
            ->orderBy('categories.name')
            ->get();

        return inertia('budgets/ShowBudget')->with(['budgetCategoryAmounts' => $budgetCategoryAmounts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budget = Budget::where('id', $id)->with('budgetCategoryAmounts')->first();

        return inertia('budgets/EditBudget')->with(['budget' => $budget, 'categories' => Category::orderBy('name')->get()]);
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
        $budget = Budget::findOrFail($id);
        $budget->name = $request->input('name');
        $budget->save();

        foreach ($request->input('budget_category_amounts') as $amount) {
            if (is_numeric($amount['amount'])) {
                BudgetCategoryAmount::updateOrCreate(
                    ['budget_id' => $budget->id, 'category_id' => $amount['category_id']],
                    ['amount' => $amount['amount']]
                );
            } else {
                BudgetCategoryAmount::where('budget_id', $budget->id)
                    ->where('category_id', $amount['category_id'])
                    ->delete();
            }
        }

        return redirect("/budgets/{$budget->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Budget::destroy($id);

        return redirect('/budgets');
    }
}
