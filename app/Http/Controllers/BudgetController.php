<?php

namespace App\Http\Controllers;

use App\DataTables\BudgetDataTable;
use App\Http\Requests\Budget\StoreRequest;
use App\Http\Requests\Budget\UpdateRequest;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BudgetDataTable $dataTable)
    {
        return $dataTable->render('budgets.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $clients = User::where('role', 'client')->get();
        return view('budgets.create', compact('clients'));
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(StoreRequest $request)
    {   
        $data = $request->validated();
        $budget = Budget::create($data);

        return redirect()->route('budgets.edit', $budget->id)->withSuccess("Budget added successfully.");
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
        $clients = User::where('role', 'client')->get();
        $budget = Budget::findOrFail($id);
        return view('budgets.edit', compact('budget', 'clients'));
    }

    /**
     * Update the specified resource in database.
     */
    public function update(UpdateRequest $request, string $id)
    {   
        $data = $request->validated();
        $budget = Budget::findOrFail($id);
        $budget->update($data);

        return back()->withSuccess('Budget updated successfully.');
    }

    /**
     * Remove the specified resource from database.
     */
    public function destroy(string $id)
    {
        //
    }
}
