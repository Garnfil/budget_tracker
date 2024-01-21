<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
