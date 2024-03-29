<?php

namespace App\Http\Controllers;

use App\DataTables\BudgetDataTable;
use App\Http\Requests\Budget\StoreRequest;
use App\Http\Requests\Budget\UpdateRequest;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $clients = User::where('role', 'client')->get();

        if($user->role == 'client') $clients = User::where('id', $user->id)->get();
        return view('budgets.create', compact('clients'));
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(StoreRequest $request)
    {   
        $data = $request->validated();
        $budget = Budget::create($data);

        $budget->update([
            'net_disposable_income' => $budget->initial_balance
        ]);

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
        $budget->update(array_merge($data, [
            'net_disposable_income' => ($budget->net_disposable_income + $request->initial_balance) - $budget->initial_balance
        ]));

        return back()->withSuccess('Budget updated successfully.');
    }

    /**
     * Remove the specified resource from database.
     */
    public function destroy(string $id)
    {
        $budget = Budget::findOrFail($id);

        $user = Auth::user();
        $user_budgets = Budget::where('user_id', $user->id)->count();

        if($user_budgets <= 1) {
            return response([
                'status' => FALSE,
                'message' => 'Your budget is only one, please add another budget to remove this budget.',
                'budget' => null
            ], 200);
        }

        $budget->delete();

        return response([
            'status' => TRUE,
            'message' => 'Budget deleted successfully.'
        ], 200);
    }

    public function getAllBudgetInfo(Request $request) {
        $id = $request->id;

        $budget = Budget::where('id', $id)->first();
        
        $recent_expenses = Expense::where('budget_id', $budget->id)->limit(5)->latest()->get();
        $recent_incomes = Income::where('budget_id', $budget->id)->limit(5)->latest()->get();
        
        return response([
            'status' => TRUE,
            'budget' => $budget,
            'recent_expenses' => $recent_expenses,
            'recent_incomes' => $recent_incomes
        ], 200);
    }
}
