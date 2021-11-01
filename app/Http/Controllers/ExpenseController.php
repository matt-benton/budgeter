<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // remove any decimals because the amount is stored as an integer
        $searchNoDecimals = str_replace('.', '', $search);

        if ($search) {
            $expenses = Expense::select('name', 'amount', 'category_id')
                ->where('amount', 'like', "%{$searchNoDecimals}%")
                ->distinct()
                ->take(10)
                ->get();
        } else {
            $expenses = Expense::all();
        }

        return response()->json(['expenses' => $expenses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('expenses/CreateExpense')->with(['categories' => Category::orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Expense::create($request->all());

        return redirect('/expenses/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::where('id', $id)->with('category')->first();
        $similarExpenses = Expense::where('name', 'like', "%{$expense->name}%")->with('category')->get();

        return inertia('expenses/ShowExpense',
            [
                'expense' => $expense,
                'similarExpenses' => $similarExpenses,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return inertia('expenses/EditExpense',
            [
                'expense' => Expense::findOrFail($id),
                'categories' => Category::all(),
            ]
        );
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
        $expense = Expense::findOrFail($id);

        $expense->amount = $request->amount;
        $expense->name = $request->name;
        $expense->date = $request->date;
        $expense->category_id = $request->category_id;
        $expense->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::destroy($id);

        return redirect('/');
    }
}
