<?php

namespace App\Http\Controllers;

use App\DataTables\BudgetDataTable;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
