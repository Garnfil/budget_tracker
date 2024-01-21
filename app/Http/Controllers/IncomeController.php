<?php

namespace App\Http\Controllers;

use App\DataTables\IncomeDataTable;
use App\Http\Requests\Income\StoreRequest;
use App\Http\Requests\Income\UpdateRequest;
use App\Models\Budget;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IncomeDataTable $dataTable)
    {
        return $dataTable->render('incomes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $budgets = Budget::get();
        return view('incomes.create', compact('budgets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $income = Income::create($data);

        $budget = Budget::where('id', $income->budget_id)->first();

        $budget->update([
            'net_disposable_income' => $budget->net_disposable_income + $income->amount
        ]);

        return redirect()->route('incomes.edit', $income->id)->withSuccess('Income added successfully');
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
        $income = Income::findOrFail($id);
        $budgets = Budget::get();
        
        return view('incomes.edit', compact('income', 'budgets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated(); 
        $income = Income::where('id', $id)->first();
        
        $budget = Budget::where('id', $income->budget_id)->first();

        $budget->update([
            'net_disposable_income' => $budget->net_disposable_income - $income->amount
        ]);

        $income->update($data);

        $budget->update([
            'net_disposable_income' => $budget->net_disposable_income + $income->amount
        ]);

        return back()->withSuccess('Income updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
