<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $table = 'budgets';
    
    protected $fillable = [
        'user_id', 
        'start_date', 
        'end_date', 
        'initial_balance', 
        'display_name', 
        'description', 
        'net_disposable_income', 
        'total_expenditure', 
        'total_budgeted'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'initial_balance' => 'double',
        'net_disposable_income' => 'double',
        'total_expenditure' => 'double',
        'total_budgeted'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
