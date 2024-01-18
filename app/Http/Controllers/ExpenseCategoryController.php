<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseCategoryDataTable;
use App\Http\Requests\ExpenseCategory\StoreRequest;
use App\Http\Requests\ExpenseCategory\UpdateRequest;
use App\Models\Budget;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExpenseCategoryDataTable $dataTable)
    {
        return $dataTable->render('expense-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $budgets = Budget::get();
        return view('expense-categories.create', compact('budgets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $expense_category = ExpenseCategory::create($data);

        return redirect()->route('expense-categories.edit', $expense_category->id)->with('Expense Category added successfully.');
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
        $expense_category = ExpenseCategory::where('id', $id)->first();

        return view('expense-categories.edit', compact('budgets', 'expense_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {   
        $data = $request->validated();
        $expense_category = ExpenseCategory::where('id', $id)->first();
        $expense_category->update($data);

        return back()->withSuccess('Expense category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
