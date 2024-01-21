<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDataTable;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Requests\Expense\UpdateRequest;
use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExpenseDataTable $dataTable)
    {
        return $dataTable->render('expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $budgets = Budget::get();
        return view('expenses.create', compact('budgets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $expense = Expense::create($data);

        $budget = Budget::where('id', $expense->budget_id)->first();

        $budget->update([
            'total_expenditure' => $budget->total_expenditure + $expense->amount
        ]);

        return redirect()->route('expenses.edit', $expense->id)->withSuccess('Expense added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $budgets = Budget::get();
        $expense = Expense::findOrFail($id);
        return view('expenses.edit', compact('expense', 'budgets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {   
        $data = $request->validated();
        $expense = Expense::findOrFail($id);
        $budget = Budget::where('id', $expense->budget_id)->first();

        $budget->update([
            'total_expenditure' => $budget->total_expenditure - $expense->amount
        ]);

        $expense->update($data);

        $budget->update([
            'total_expenditure' => $budget->total_expenditure + $expense->amount
        ]);

        return back()->withSuccess('Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);

        $expense->delete();

        return response([
            'status' => TRUE,
            'message' => 'Expense deleted successfully'
        ], 200);
    }
}
