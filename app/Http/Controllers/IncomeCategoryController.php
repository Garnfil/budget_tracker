<?php

namespace App\Http\Controllers;

use App\DataTables\IncomeCategoryDataTable;
use App\Http\Requests\IncomeCategory\StoreRequest;
use App\Http\Requests\IncomeCategory\UpdateRequest;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;

class IncomeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IncomeCategoryDataTable $dataTable)
    {
        return $dataTable->render('income-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $budgets = Budget::with('user')->get();
        return view('income-categories.create', compact('budgets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {   
        $data = $request->validated();
        $income_category = IncomeCategory::create($data);

        return redirect()->route('income-categories.edit', $income_category->id)->withSuccess('Income Category added successfully.');
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
        $budgets = Budget::with('user')->get();
        $income_category = IncomeCategory::findOrFail($id);
        return view('income-categories.edit', compact('budgets', 'income_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {   
        $data = $request->validated();
        $income_category = IncomeCategory::findOrFail($id);
        $income_category->update($data);
        
        return back()->withSuccess('Income Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $income_category = IncomeCategory::findOrFail($id);

        $income_category->delete();

        return response([
            'status' => TRUE,
            'message' => 'Income Category deleted successfully.'
        ], 200);
    }

    public function lookup(Request $request) {
        $type = $request->type;

        $income_categories = IncomeCategory::select('id', 'name', 'budget_id')->where('name', 'like', $request->q . '%')->get();

        if($type == 'budget') {
            $income_categories = IncomeCategory::select('id', 'name', 'budget_id')->where('budget_id', $request->q)->get();
        }

        return [
            'status' => TRUE,
            'income_categories' => $income_categories
        ];
    }
}
