<?php

namespace App\Traits;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

trait ClientDashboard {
    public function clientDashboard() {
        $user = Auth::user();
        $current_budget = Budget::where('user_id', $user->id)->latest()->first();

        $budgets = Budget::where('user_id', $user->id)->latest()->get();
        
        return view('dashboard.client.client-dashboard', compact('budgets', 'current_budget'));
    }
}